<?php
namespace Admin\Controller;
use Think\Controller;
/*
*后台登陆控制器
*/
class LoginController extends Controller {

	public function index(){
        $this->display();
    }

    //登录验证
    public function login(){
    	if(!IS_POST){
    		$this->error('页面不存在');
    	}

		$username = I('post.username');
		$password = I('post.password');
		$user = M('user_member')->where(array('stu_num' => $username))->find();
        $uri = "http://hongyan.cqupt.edu.cn/RedCenter/Api/Handle/login";
        // 参数数组
        $data = array(
            'user' => $username,
            'password' => $password
        );
        $re = $this->curl($data, $uri);
        switch ($re['status']) {
            case '200':
                $this->successHandle($user);
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

    private function successHandle($user){
        $data = array(
            'id' => $user['id'],
            'last_login_time' => time(),
            'last_login_ip' => get_client_ip(),
        );
        M('user_member')->save($data);

        session(C('USER_AUTH_KEY'), $user['id']);
        session('user_name', $user['nickname']);
        session('user_email', $user['email']);
        session('user_login_time', date('Y-m-d H:i:s', $user['last_login_time']));
        session('user_login_ip', $user['last_login_ip']);

        //超级管理员识别
        if ($user['real_name'] == C('RBAC_SUPERADMIN')) {
            session(C('ADMIN_AUTH_KEY'), true);
        }
        //读取用户权限
        $Rbac = new \Org\Util\Rbac();
        $Rbac->saveAccessList();

        $this->success('登陆成功', __ROOT__ . '/index.php/Admin/Index/index');
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


?>