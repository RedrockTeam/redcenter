<?php

namespace Home\Controller;
use Home\myLib\UserInfo;
use Think\Controller;
use Home\myLib\JSSDK;

class PhoneController extends Controller {
    public function index(){
        $jssdk = new JSSDK("wx81a4a4b77ec98ff4", "436e85f53285ed7a0038f448a78fda66"); //cyxbs
        $signPackage = $jssdk->GetSignPackage();
        $this->assign("signPackage", $signPackage);

        //判断方法
        if(IS_POST){
            $stunum = I('post.stu');
        }else{
            //根据stunum获取个人信息和总分数
            $stunum = I('get.stu');
        }

        $userInfo = new UserInfo($stunum);
        $info = $userInfo->getSelfInfo();

        //已经绑定了的用户, 每一次访问时就在微信访问次数上加一
        if($info){
            $Model = M('user_member');
            $data['id'] = $info['id'];
            $data['weixin_visit_num'] = $info['weixin_visit_num']+1;
            $Model->save($data);
        }

        //第一次访问的已绑定用户, 把学号传过去
        if($info && $info['weixin_visit_num'] == 0) {
            $this->redirect('Intro/index', array('stu' => $stunum));
        }

        //未进行学号绑定的, 学号错误的, 传学号为0
        if(!$stunum || !$info){
            $this->redirect('Intro/index', array('stu' => ''));
        }

        //获取排名
        $selfRank = $userInfo->getSelfRank();

        //查询不同应用分别对用的积分
        $weixinInfo = M('user_log')->where(array('user_id' => $info['id'], 'project' => '微信'))->select();
        $weixinScore = 0;
        foreach($weixinInfo as $value){
            $weixinScore = $value[score]+$weixinScore;
        }

        //总分排行榜
        $rankList = $userInfo->getRankList(10);

        //获取头像
        $headImage = $userInfo->getHeadImg();


        if(IS_POST){
            $this->ajaxReturn(array(
                'headImage' => $headImage,
                'selfRank' => $selfRank,
                'rankList' => $rankList,
                'weixinScore' => $weixinScore,
                'info' => $info
            ));
        }else{
            $this->assign('headImage', $headImage);
            $this->assign('self', $selfRank);
            $this->assign('rank', $rankList);
            $this->assign('weixin', $weixinScore);
            $this->assign('info', $info);
            $this->display();
        }
    }
}