<?php
/**
 * 教师注册
 * by Lich
 * 2015-11-13 20:58:29
 */
namespace Home\Controller;
use Org\Util\String;
use Think\Controller;
class TeacherRegisterController extends Controller{

    //注册页面, csrf防御
    public function index() {
        $str = new String();
        $csrf_token = $str->randString(32);
        session('csrf_token', $csrf_token);
        $this->assign('csrf_token', $csrf_token);
        $this->display();
    }

    public function register() {

        if(!IS_POST) {
            $this->error('405 method not allow');
        }
        $data = I('post.');
        var_dump($data);
        $csrf_token = session('csrf_token');
        var_dump($csrf_token);
        if($csrf_token !== $data['csrf_token']) {
            $this->error('csrf');
        }
        if($data['email'] == '' || $data['username'] == '' || $data['nickname'] == '') {
            $this->error('参数错误');
        }

        if(mb_strlen($data['username']) > 30 || mb_strlen($data['nickname']) > 30) {
            $this->error('参数过长');
        }
        if($data['password'] !== $data['password_verify']) {
            $this->error('输入的两次密码不一致');
        }
        $num = M('user_member')->where(array('email' => $data['email'].'@cqupt.edu.cn'))->count();
        if($num != 0) {
            $this->error('你已注册, 如忘记密码请联系红岩网校工作站重置密码');
        }
        $str = new String();
        $salt = $str->randString(6);
        $verify_code = md5(sha1(time()+1024).$data['email']);
        $password = md5(md5($data['password']).$salt);
        $row = array(
            'time' => time(),
            'salt' => $salt,
            'stu_num' => $data['username'],
            'email' => $data['email'].'@cqupt.edu.cn',
            'type_id' => 1,
            'nickname' => $data['nickname'],
            'verify_code' => $verify_code,
            'password' => $password,
            'status' => 1
        );
        $subject = '=?UTF-8?B?'.base64_encode('认证邮件').'?=';
        $url = $_SERVER['HTTP_HOST'].U('TeacherRegister/emailVerify')."?code=".$verify_code;
        $content = "点击链接验证邮箱\r\n$url";
        if(mail($data['email'].'cqupt.edu.cn', $subject, $content, 'from:redrock@cqupt.edu.cn')) {
            M('email_verify')->add($row);
            $this->success('注册成功, 请在12小时内前往教师邮箱激活账号~');
        }
        $this->error('好像出了点小问题...');
    }

    public function emailVerify() {
        $code = I('get.code', '');
        $row = M('email_verify')->where(array('verify_code' => $code))->find();
        if(!$row) {
            $this->error('无效链接');
        }
        if($row['status'] != 1) {
            $this->error('已经激活');
        }
        if((time() - $row['time']) > (12*3600) ) {
            $this->error('验证超时');
        }
        M('email_verify')->where(array('id' => $row['id']))->save(array('status' => 0));
        $data = array(
            'stu_num' => $row['stu_num'],
            'email' => $row['email'],
            'password' => $row['password'],
            'nickname' => $row['nickname'],
            'salt' => $row['salt'],
            'status' => 1,
            'score' => 0,
            'weixin_visit_num' => 0,
            'identify_code' => 0
        );
        if(M('user_member')->add($data)) {
            $this->success('激活成功', U('Index/login'));
        }
        $this->error('好像出了点小问题...');
    }
}