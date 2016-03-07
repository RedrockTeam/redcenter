<?php
namespace Admin\Controller;
use Think\Controller;

class PublishController extends CommonController {

    public function index(){
        if(IS_POST){
            $data['title'] = I('post.title');
            $data['for_who'] = I('post.for_who');
            $data['content'] = I('post.content');
            $type = I('post.type');    //分消息发布type=new 帮助发布type=help
            M($type.'_center')->add($data);

            /*if(I('post.type') == 'help')
                M('help_center')->add($data);
            if(I('post.type') == 'news')
                M('new_center')->add($data);*/
        }
    }



}