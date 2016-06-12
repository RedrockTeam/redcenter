<?php
namespace Api\Controller;
use Think\Controller;
use Home\myLib\UserInfo;

class HandleController extends Controller {
    private $userinfo;
    public function index(){
        if(!IS_POST){
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => 'token error',
                'status' => 403
            ),'json');
        }
        $type = I('post.type');
        $stu_num = I('post.stu');
        $token = I('post.token');
        $pro_id = I('post.id');//应用名称, 例如cyxbs代表重邮小帮手；BTdown代表BT当铺
        $this->userinfo = M('user_member')->where(array('stu_num' => $stu_num))->find();
        $uid = $this->userinfo['id'];

        $log_res = M('user_log')->where(array('user_id' => $this->userinfo['id']))->order('id desc')->find();
        $last_log_time = $log_res['create_time'];
        //验证学号是否正确
        if($this->userinfo){
            if(date('m',$last_log_time) != date('m')){
                $save['score_month'] = 0;
                $save['last_month_rank'] = $this->userinfo['month_rank'];
                $save['month_rank'] = 0;
                M('user_member')->where(array('stu_num' => $stu_num))->save($save);
                unset($save);//$save用的太多了  还用用完就清除吧
            }
            //如果本次加分记录和上次加分记录处不是同一年，上年积分置0，再进行本次加分
            if(date('Y',$last_log_time) != date('Y')){
                $save['score'] = 0;
                $save['last_year_rank'] = $this->userinfo['year_rank'];
                $save['year_rank'] = 0;
                M('user_member')->where(array('stu_num' => $stu_num))->save($save);
                unset($save);
            }
            //user_member表已更新，需重新获取数据
            $this->userinfo = M('user_member')->where(array('stu_num' => $stu_num))->find();
        }else{
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => 'no this student',
                'status' => 401
            ),'json');
        }
        //验证type是否选择查询分数
        if($type == 'getScore'){
            $score = $this->userinfo['score'];
            if(is_null($score)){
                send_http_status('403');
                $this->ajaxReturn(array(
                    'error' => 'no this student',
                    'status' => 401
                ),'json');
            }else{
                $this->ajaxReturn(array(
                    'score' => $score,
                    'status' => 200
                ));
            }
        }else{
            //符合type的action的信息
            $act = M('action')->where(array('type' => $type))->find();
            if(!$act){
                send_http_status('403');
                $this->ajaxReturn(array(
                    'error' => 'no this action',
                    'status' => 402
                ),'json');
            }
        }
        //根据project_id得到的project的值
        $pro_obj = M('project_token')->where(array('project_id' => $pro_id))->find();
        $pro = $pro_obj['project'];
        if(!$pro){
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => 'no this project_id',
                'status' => 403
            ),'json');
        }
        /* //验证学号是否正确
         if(!$this->userinfo){
             send_http_status('403');
             $this->ajaxReturn(array(
                 'error' => 'token error',
                 'status' => 403
             ),'json');
         }*/
        //验证token是否正确
        $testToken = generateToken($pro_id,$stu_num,$type);
        if($testToken != $token){
            send_http_status(403);
            $this->ajaxReturn(array(
                'error' => 'token error',
                'status' => 404
            ),'json');
        }
        if(isFull($stu_num, $act, $pro)){
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => '加分已达今日上限',
                'status' => 405
            ),'json');
        }else{
           /* $last_log_time = M('user_log')->where(array('user_id' => $this->userinfo['id']))->order('id desc')->find()['create_time'];
            
            //如果本次加分记录和上次加分记录处不是同一月，上月积分置0，再进行本次加分
            if(date('m',$last_log_time) != date('m')){
                $save['score_month'] = 0;
                $save['last_month_rank'] = $this->userinfo['month_rank'];
                $save['month_rank'] = 0;
                M('user_member')->where(array('stu_num' => $stu_num))->save($save);
            }
            //如果本次加分记录和上次加分记录处不是同一年，上年积分置0，再进行本次加分
            if(date('Y',$last_log_time) != date('Y')){
                $save['score'] = 0;
                $save['last_year_rank'] = $this->userinfo['year_rank'];
                $save['year_rank'] = 0;
                M('user_member')->where(array('stu_num' => $stu_num))->save($save);
            }

            //user_member表已更新，需重新获取数据
            $this->userinfo = M('user_member')->where(array('stu_num' => $stu_num))->find();*/
            //向user_log表添加一条数据
            $data['user_id'] = $this->userinfo['id'];
            $now = time();
            $data['create_time'] = $now;
            $data['project'] = $pro;
            $data['action'] = $act['description'];
            $data['score'] = $act['once'];
            M('user_log')->data($data)->add();
            unset($data);
            //在年度总分的基础上加分,值不能为负，最低为0
            $save['score'] = $this->userinfo['score']+$act['once'] < 0 ? 0 : $this->userinfo['score']+$act['once'];
            //在总经验的基础上加分,值不能为负，最低为0
            $save['experience'] = $this->userinfo['experience']+$act['once'] < 0 ? 0 : $this->userinfo['experience']+$act['once'];
            //在该月总积分的基础上加分,值不能为负，最低为0
            $save['score_month'] = $this->userinfo['score_month']+$act['once'] < 0 ? 0 : $this->userinfo['score_month']+$act['once'];
            $save['score_update_time'] = $now;//最后1次更新积分的时间
            $save['id'] = $this->userinfo['id'];
            $save['weixin_visit_num'] = $this->userinfo['weixin_visit_num'] + 1;
            $save['last_login_time'] = time();
            $save['last_login_ip'] = $this->getIp();
            M('user_member')->save($save);
            unset($save);
            //user_member更新,分数改变后，月排名和年排名可能会变化 ，通过userinfo类的构造方法跟新排名
            $userinfo_object = new userInfo($stu_num);

            /*$data['month_rank'] = $userinfo_object->getSelfRank_month();
            $data['year_rank'] = $userinfo_object->getSelfRank();
            $data['id'] = $uid;
            M('user_member')->save($data);*/
            
            $this->ajaxReturn(array(
                'status' => 200,
                'data' => $last_log_time,
                'stu_num' => $stu_num
            ),'json');
        }
    }


    public function login(){
        $_user = I('post.user', 0);
        $passwd = I('post.password');
        if(!$_user || empty($passwd)) return $this->_return(408);

        strlen($_user) == 10 ? $map['stu_num'] = $_user : $map['identify_code'] = $_user;
        $userRecord = M('user_member')->where($map)->find();
        if(empty($userRecord)) return $this->_return(409);
        if(!$userRecord['password']) {//有密码的就不能后6位登录了!!! by Lich
            //verify
            if(strlen($passwd) == 6 || strlen($passwd) == 5){
                //这里进入身份证判断, 验证静默失败
                $passwdLower = strtolower($passwd);
                if($passwdLower == strtolower(substr($userRecord['stu_idcard'], -6)) || $passwdLower == strtolower(substr($userRecord['stu_idcard'], -5))){
                    unset($userRecord['password']);
                    unset($userRecord['salt']);
                    return $this->_return(200, array(
                        'userInfo' => $userRecord
                    ));
                }
            }
        }
        //下面是ucenter密码判断
        $encodedPassword = md5(md5($passwd).$userRecord['salt']);
        if($encodedPassword == $userRecord['password']){
            unset($userRecord['password']);
            unset($userRecord['salt']);
            $this->_return(200, array(
                'userInfo' => $userRecord
            ));
        }else{
            $this->_return(408, array(
                "uid" => $userRecord['id']
            ));
        }
    }

    private $codeMap = array(
        "200" => "success",
        "408" => "error user or password",
        "409" => "user not found"
    );
    private function _return($code, $arr = null) {
        $raw = array(
            "status" => "$code",
            "info" => $this->codeMap[$code]
        );

        if($arr != null){
            foreach($arr as $k => $v){
                $raw[$k] = $v;
            }
        }
        return $this->ajaxReturn($raw);
    }

    private function getIp(){
        if (getenv("HTTP_CLIENT_IP"))
            $ip = getenv("HTTP_CLIENT_IP");
	    else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("REMOTE_ADDR"))
            $ip = getenv("REMOTE_ADDR");
	    else
	        $ip = "";

	    return $ip;
    }
}