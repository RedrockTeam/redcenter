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
            $this->error('验证码错误');
        }
        if(mb_strlen($data['stunum'], 'utf-8') != 10) {
            $this->error('学号错误');
        }
        $email = M('user_member')->where(array('stu_num' => $data['stunum']))->getField('email');
        if (!$email) {
            $this->error('无此学号');
        } else {
            if($this->mail($email, $data['stunum'])){
                $this->success('邮件发送成功, 请前往邮箱收取检查(默认为)', '', 10);
            } else {
                $this->error('邮件发送发生错误, 请联系红岩网校工作站或稍后再试!');
            }
        }

    }

    //重置密码页面
    public function reset(){
        $token = I('get.token');

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