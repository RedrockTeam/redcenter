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