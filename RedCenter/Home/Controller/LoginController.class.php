<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/15
 * Time: 12:52
 */
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller{

    public function loginHandle(){
        $username = I('post.user');
        $password = I('post.password');

        $uri = "http://hongyan.cqupt.edu.cn/RedCenter/Api/Handle/login";
        // 参数数组
        $data = array(
            'user' => $username,
            'password' => $password
        );
        $re = $this->curl($data, $uri);
        var_dump($re);
        return;
        switch ($re['status']) {
            case '200':
                session('stunum', $re['userInfo']['stu_num']);
                $this->redirect('Home/Index/index');
                break;
            case '408':
                $this->error('用户名或密码错误');
                break;
            case '409':
                $this->error('用户名不存在');
                break;
            default:
                $this->error('登陆失败');
        }
    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('Home/Index/login');
    }

    public function register(){
        $this->show("reg");
    }

    private function curl($info, $uri)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $info);
        $return = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($return, true);    //json字符串转化为数组

        return $result;
    }
}