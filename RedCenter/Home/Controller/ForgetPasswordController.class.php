<?php
/**
 * Created by PhpStorm.
 * User: Lich
 * Date: 16/5/5
 * Time: 15:40
 */
namespace Home\Controller;
use Org\Util\String;
use Think\Controller;
use Think\Verify;

class ForgetPasswordController extends Controller {

    //重置密码申请页面
    public function index(){
        $str = new String();
        $csrf_token = $str->randString(32);
        session('csrf_token', $csrf_token);
        $this->assign('csrf_token', $csrf_token);
        $this->display();
    }
    //验证码
    public function getCode(){
        $verify = new Verify();
        $verify->entry();
    }
    //
    public function accept(){
        $data = I('post.');
        $verify = new Verify();
        if(!$verify->check($data['code'])){
            $this->ajaxReturn(array(
                'status' => 403,
                'info' => '验证码错误'
            ));
        }
        if(mb_strlen($data['stunum'], 'utf-8') != 10) {
            $this->ajaxReturn(array(
                'status' => 403,
                'info' => '学号/教师一卡通号错误'
            ));
        }
        $email = M('user_member')->where(array('stu_num' => $data['stunum']))->getField('email');
        if (!$email) {
            $this->ajaxReturn(array(
                'status' => 403,
                'info' => '无此学号/教师一卡通号'
            ));
        } else {
            if($this->mail($email, $data['stunum'])){
                $this->ajaxReturn(array(
                    'status' => 200,
                    'info' => '成功',
                    'data' => $email
                ));
//                $this->success('邮件发送成功, 请12小时内前往邮箱('.$email.')收取检查', '', 10);
            } else {
                $this->ajaxReturn(array(
                    'status' => 500,
                    'info' => '邮件发送发生错误, 请联系红岩网校工作站或稍后再试!'
                ));
            }
        }

    }

    //重置密码页面
    public function reset(){
        $token = I('get.code', '');
        $row = M('email_verify')->where(array('verify_code' => $token))->find();
        if(!$row) {
            $this->error('无效链接');
        }
        if($row['status'] != 1) {
            $this->error('已经激活');
        }
        if((time() - $row['time']) > (12*3600) ) {
            $this->error('验证超时');
        }
        $this->assign('token', $token);
        $this->display();
    }

    //
    public function resetPwd(){
        $input = I('post.');
        if(!$input['token']){
            $this->error('参数错误');
        }
        $row = M('email_verify')->where(array('verify_code' => $input['token']))->find();
        if(!$row) {
            $this->error('无效链接');
        }
        if($row['status'] != 1) {
            $this->error('已经激活');
        }
        if((time() - $row['time']) > (12*3600) ) {
            $this->error('验证超时');
        }
        if(mb_strlen($input['password'], 'utf-8')<6){
            $this->error('密码太短');
        }
        if($input['password'] !== $input['repeat']){
            $this->error('两次密码不一致');
        }
        $str = new String();
        $salt = $str->randString(6);
        $pwd = md5(md5($input['password']).$salt);
        M('user_member')->where(array('stu_num' => $row['stu_num']))->save(array('password' => $pwd, 'salt' => $salt));
        M('email_verify')->where(array('stu_num' => $row['stu_num']))->save(array('status' => 0));
        $this->success('修改成功', U('Login/index'));
    }

    private function mail($email, $stunum){
        $str = new String();
        $salt = $str->randString(6);
        $verify_code = md5(sha1(time()+1024).$email);
        $row = array(
            'time' => time(),
            'salt' => $salt,
            'stu_num' => $stunum,
            'email' => '',
            'type_id' => 2,
            'nickname' => '',
            'verify_code' => $verify_code,
            'password' => '',
            'gender'    => '',
            'status' => 1
        );
        $subject = '=?UTF-8?B?'.base64_encode('重置密码').'?=';
        $url = 'http://'.$_SERVER['HTTP_HOST'].U('ForgetPassword/reset')."?code=".$verify_code;
        $content = "link: \r\n$url";
        $return = $this->curl_api('http://hongyan.cqupt.edu.cn/phpmail/test.php', array('subject' => $subject, 'content' => $content, 'email' => $email));

        if($return->status == 200) {
            M('email_verify')->add($row);
            return true;
        } else {
            return false;
        }
    }

    /*curl通用函数*/
    private function curl_api($url, $data=''){
        // 初始化一个curl对象
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        // 运行curl，获取网页。
        $contents = json_decode(curl_exec($ch));
        // 关闭请求
        curl_close($ch);
        return $contents;
    }
}