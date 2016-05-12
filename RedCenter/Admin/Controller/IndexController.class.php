<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {

    public function index(){
        $content = $this->fetch('userManage');
        $this->assign('content', $content);
        $this->display();
    }

    public function publishMessage(){
        $this->display();
    }

    public function publishHelp(){
        $this->display();
    }

    public function userManager(){
        $this->display();
    }

    public function queryData(){

    }

    public function test(){
//        $this->show('<html><form action="'.U('Publish/upload').'" method="post" enctype="multipart/form-data"><input name="a" type="file"><input type="submit" value="上传"></form>','utf-8');
        var_dump(I('session.'));
        if(checkSuperUser())
            echo 'true';
        else
            echo 'false';
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