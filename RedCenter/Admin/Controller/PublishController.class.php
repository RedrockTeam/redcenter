<?php
namespace Admin\Controller;
use Think\Controller;

class PublishController extends CommonController {

    public function index(){
        if(IS_POST){
            $new['title'] = I('post.title');
            $new['for_who'] = I('post.for_who');
            $new['content'] = I('post.content');
            $new['content'] = I('post.type');//分消息发布 帮助发布
            M('***')->add($new);
        }
    }



}