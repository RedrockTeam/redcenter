<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {

    public function index(){
        $this->assign('user_name', session(user_name));
        $this->display();
    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('Admin/Login/index');
    }

    public function listUser(){
        $page = I('get.page',1);
        if(!is_numeric($page))
            $this->error("分页请求错误!");
        $page = intval($page);
        $users = M('user_member');
        //$user_count = $users->

    }

    public function searchUser(){
        $type = I('post.type','name');
        $search_content = I('post.content','');
        if(empty($search_content)){
            $this->ajaxReturn("请输入内容!");
            return;
        }
        $type_array = array('name','stuid','phone');
        if(!in_array($type,$type_array))
            $type = 'name';

        $user = M('user_member');
        switch($type){
            case 'name':
                $type = 'real_name';
                break;
            case 'stuid':
                $type = 'stu_num';
                break;
            case 'phone':
                $type = 'phone';
                break;
            default:
                $type = 'name';
                break;
        }

        $condition = array($type => array('like','%'.$search_content.'%'));
        $result = $user->where($condition)->select();
        //header("Content-Type:text/html;charset=utf-8");
        //var_dump($result);

        $this->assign('name',$result['real_name']);
    }

    public function addUser(){

    }

    public function editUser(){
        $real_name = I('post.name');
        $gender = I('post.gender');
        $stu_num = I('post.stuid');
        $phone = I('phone');
        $id_card = I('id_card');
        $email = I('e_mail');

        if(empty($stu_num)){
            $this->ajaxReturn('1');// 用户名为空
            return;
        }

        $data = array(
            'real_name' => $real_name,
            'gender' => $gender,
            'stu_idcard' => $id_card,
            //'phone' => $phone, //当前数据表中无此字段
            'email' => $email
            );
        $condition = array('stu_num' => $stu_num);

        $user = M('user_member');
        $result = $user->where($condition)->save($data);
        if($result){
            $this->ajaxReturn('2');//更新成功
            return;
        }else{
            $this->ajaxReturn('3');//更新失败
            return;
        }
    }

    public function userManager(){
        $this->assign('resource',"<link rel=\"stylesheet\" href=\"".C('TMPL_PARSE_STRING.__PUBLIC__')."/v2/less/user-manage.css\">");
        $this->display();
    }

    public function test(){
    }
}











/*array(
    'total_num' =>'43',
    'article' => array(
        '0'=>array('title'=>'重邮小帮手','content'=>'afsasf','for_who'=>'重邮小帮手','time'=>'8:34:34'),
        '1'=>array('title'=>'重邮小帮手','content'=>'afsasf','for_who'=>'重邮小帮手','time'=>'8:34:34'),
        '2'=>array('title'=>'重邮小帮手','content'=>'afsasf','for_who'=>'重邮小帮手','time'=>'8:34:34'),
        '3'=>array('title'=>'重邮小帮手','content'=>'afsasf','for_who'=>'重邮小帮手','time'=>'8:34:34'),
        '4'=>array('title'=>'重邮小帮手','content'=>'afsasf','for_who'=>'重邮小帮手','time'=>'8:34:34'),
    )
)*/