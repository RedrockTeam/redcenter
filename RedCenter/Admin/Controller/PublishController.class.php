<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class PublishController extends CommonController {

    public function addArticle(){
        if(!IS_POST) {
            $this->ajaxReturn('false');
        }

        $data['title'] = I('post.title');
        $data['content'] = I('post.content');
        $data['pro_id'] = I('post.pro_id');
        $data['pro_name'] = I('post.pro_name');
        $data['time'] = data('Y-m-d H:i:s',time());
        $data['writer'] = I('session.real_name');
        //$data['view'] = 0; //访问量
        $table = I('post.type').'_center';
        $result = M($table)->add($data);
        if($result){
            $this->ajaxReturn(true);
        }else{
            $this->ajaxReturn(false);
        }

    }

    public function getArticle(){

    }

    public function upload(){
        $upload = new Upload();
        $upload->maxSize = 10 * (1 << 20);
        $upload->exts = array('jpg', 'png', 'zip');
        $upload->rootPath = APP_PATH.'Admin/Public/upload/';
        $info = $upload->upload();
        if($info){
            $this->ajaxReturn(json_encode($info,true), 'json');
            return;
        }else{
            $this->ajaxReturn('fail');
            return;
        }
    }



}