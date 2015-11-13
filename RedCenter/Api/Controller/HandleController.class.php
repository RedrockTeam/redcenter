<?php
namespace Api\Controller;
use Think\Controller;
use Home\myLib\UserInfo;

class HandleController extends Controller {
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
        $pro_id = I('post.id');//应用名称, 例如cyxbs

        //验证type是否选择查询分数
        if($type == 'getScore'){
            $score = M('user_member')->where(array('stu_num' => $stu_num))->find()['score'];
            if(is_null($score)){
                send_http_status('403');
                $this->ajaxReturn(array(
                    'error' => 'token error',
                    'status' => 403
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
                    'error' => 'token error',
                    'status' => 403
                ),'json');
            }
        }
        //根据project_id得到的project的值
        $pro = M('project_token')->where(array('project_id' => $pro_id))->find()['project'];
        if(!$pro){
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => 'token error',
                'status' => 403
            ),'json');
        }
        //验证学号是否正确
        $stu = M('user_member')->where(array('stu_num' => $stu_num))->find();
        if(!$stu){
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => 'token error',
                'status' => 403
            ),'json');
        }
        //验证token是否正确
        $testToken = generateToken($pro_id,$stu_num,$type);
        if($testToken != $token){
            send_http_status(403);
            $this->ajaxReturn(array(
                'error' => 'token error',
                'status' => 403
            ),'json');
        }
        if(isFull($stu_num, $act, $pro)){
            send_http_status('403');
            $this->ajaxReturn(array(
                'error' => '加分已达今日上限',
                'status' => 403
            ),'json');
        }else{
            //向user_log表添加一条数据
            $userid = M('user_member')->where(array('stu_num' => $stu_num))->find()['id'];
            $data['user_id'] = $userid;
            $data['create_time'] = time();
            $data['project'] = $pro;
            $data['action'] = $act['description'];
            $data['score'] = $act['once'];
            M('user_log')->data($data)->add();
            //在总分的基础上加分
            $personSumScore = M('user_member')->where(array('stu_num' => $stu_num))->find()['score'];
            $personSumScore += $act['once'];
            if($personSumScore < 0){$personSumScore = 0;}
            $id = M('user_member')->where(array('stu_num' => $stu_num))->find()['id'];
            M('user_member')->data(array('id' => $id, 'score' => $personSumScore))->save();

            $this->ajaxReturn(array(
                'status' => 200
            ),'json');
        }
    }


    public function login(){
        $_user = I('post.user', 0, 'int');
        $passwd = I('post.password');
        if(!$_user || empty($passwd)) return $this->_return(408);

        strlen($_user) == 10 ? $map['stu_num'] = $_user : $map['identify_code'] = $_user;
        $userRecord = M('user_member')->where($map)->find();
        if(empty($userRecord)) return $this->_return(409);
        if(!$userRecord['password']) {//有密码的就不能后6位登录了!!! by Lich
            //verify
            if(strlen($passwd) == 6){
                //这里进入身份证判断, 验证静默失败
                $passwdLower = strtolower($passwd);
                if($passwdLower == strtolower(substr($userRecord['stu_idcard'], -6))){
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
}