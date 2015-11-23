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

    //注册方法
    public function register() {

        if(!IS_POST) {
            $this->error('405 method not allow');
        }
        $data = I('post.');
        $csrf_token = session('csrf_token');
        if($csrf_token !== $data['csrf_token']) {
            $this->error('csrf');
        }
        if($data['email'] == '' || $data['username'] == '' || $data['nickname'] == '') {
            $this->error('所有数据都要填...');
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
            'gender'    => $data['gender'],
            'status' => 1
        );
        $subject = '=?UTF-8?B?'.base64_encode('认证邮件').'?=';
        $url = 'http://'.$_SERVER['HTTP_HOST'].U('TeacherRegister/emailVerify')."?code=".$verify_code;
        $content = "Account verify link: \r\n$url";
        $email = $data['email'].'@cqupt.edu.cn';
        $return = $this->curl_api('hongyan.cqupt.edu.cn/phpmail/test.php', array('subject' => $subject, 'content' => $content, 'email' => $email));
        if($return->status == 200) {
            M('email_verify')->add($row);
            $this->success('注册成功, 请在12小时内前往学校教师邮箱激活账号~', 'http://mail.cqupt.edu.cn/', 10);
            return;
        }
        $this->error('好像出了点小问题...');
    }

    //邮件验证
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
            'stu_num' => '',
            'email' => $row['email'],
            'password' => $row['password'],
            'nickname' => $row['nickname'],
            'salt' => $row['salt'],
            'status' => '1',
            'score' => 0,
            'weixin_visit_num' => 0,
            'identify_code' => $row['stu_num'],
            'gender' => $row['gender']
        );
        if(M('user_member')->add($data)) {
            $this->success('激活成功, 请记住您的账号和密码, 小帮手绑定请用此账号和密码~', 'http://redrock.cqupt.edu.cn/shuangshijia/');
            return;
        }
        $this->error('好像出了点小问题...');
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

    //教师绑定
    public function teacherBindVerify() {
        if(!IS_POST) {
            $this->ajaxReturn(array('status' => 405, 'info' => 'Method Not Allowed'));
        }
        $input = I('post.');
        $data = M('user_member')->where(array('identify_code' => $input['identify_code']))->field('salt, identify_code, password, email, nickname, gender')->find();
        if(!$data) {
            $this->ajaxReturn(array('status' => 403, 'info' => '验证失败'));
        }
        $password =  md5(md5($input['password']).$data['salt']);
        if($password == $data['password']) {
            unset($data['password']);
            unset($data['salt']);
            $this->ajaxReturn(['status' => 200, 'info' => 'Success', 'data' => $data]);
        } else {
            $this->ajaxReturn(array('status' => 403, 'info' => '验证失败'));
        }
    }

}