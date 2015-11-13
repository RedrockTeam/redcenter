<?php
namespace Home\Controller;
use Think\Controller;
use Home\myLib\UserInfo;

class IndexController extends CommonController {

    /**
     * 前台 用户中心
     */
    public function index(){
        var_dump($_SESSION);
        if(is_null(session('stunum'))){
            $this->redirect('Home/Index/login');
        }
        $stunum = session('stunum');
        $userInfo = new UserInfo($stunum);
        $info = $userInfo->getSelfInfo();

        //用户基本信息
        $this->assign('nickName', $info['nickname']);
        $this->assign('selfRank', $userInfo->getSelfRank());
        $this->assign('selfScore', $info['score']);
        $this->assign('rankList', $userInfo->getRankList(4));
        $this->assign('headImage', $userInfo->getHeadImg());

        //我的中心
        $this->assign('userLog', $userInfo->getLog());  //所有动态
        $this->assign('BTdownLog', $userInfo->getLog(null,'BTdown铺'));
        $this->assign('marketLog', $userInfo->getLog(null,'拾货'));
        $this->assign('jsnsLog', $userInfo->getLog(null,'锦瑟南山'));
        $this->assign('zscyLog', $userInfo->getLog(null,'掌上重邮'));
        $this->assign('cyxbsLog', $userInfo->getLog(null,'微信'));

        //积分细则
        $this->assign('rule', $userInfo->getRule());
        $this->assign('BTdownRule', $userInfo->getRule('BTdown铺'));
        $this->assign('marketRule', $userInfo->getRule('拾货'));
        $this->assign('jsnsnRule', $userInfo->getRule('锦瑟南山'));
        $this->assign('zscyRule', $userInfo->getRule('掌上重邮'));
        $this->assign('cyxbsRule', $userInfo->getRule('微信'));

        //用户等级
        $this->assign('userLevel', $userInfo->getLevel());

        //积分等级
        $this->assign('levelRule', $userInfo->getLevelRule());
//dd($userInfo->getLevelRule());
        $this->display();
    }

    public function login(){
        $this->display();
    }

    public function signUp(){
        $this->display();
    }
}