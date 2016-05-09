<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;

class PublishController extends CommonController {

    public function addArticle(){
        if(!IS_POST) {
            $this->error('似乎出了一点问题');
        }

        $data['title'] = I('post.title');
        $data['visible'] = I('post.is_public',1) == 1?0:I('post.visible_product',1);//先判断是否所有人可见，是 0 否 具体产品 1-n
        $data['content'] = I('post.content');
        $data = I('post.type') == 'notice'?'notice':'help';    //分消息发布type=notice 帮助发布type=help

        $data['create_time'] = time();
        $data['author'] = I('session.user_name');
        //$data['view'] = 0; //访问量
        $data['is_delete'] = 0;

        $result = M('news')->add($data);
        if($result){
            $this->ajaxReturn('ok');
        }else{
            $this->ajaxReturn('fail');
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