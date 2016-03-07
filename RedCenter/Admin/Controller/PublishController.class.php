<?php
namespace Admin\Controller;
use Think\Controller;

class PublishController extends CommonController {

    public function index(){
        if(IS_POST){
            $data['title'] = I('post.title');
            $data['pro_id'] = I('post.pro_id');
            $data['pro_name'] = I('post.pro_name');
            $data['content'] = I('post.content');
            $type = I('post.type');    //分消息发布type=new 帮助发布type=help
            M($type.'_center')->add($data);

        }
    }



}