<?php
/**
 * Created by PhpStorm.
 * User: Liuchenling
 * Date: 4/22/15
 * Time: 14:24
 */

namespace Home\Controller;
use Home\myLib\UserInfo;
use Think\Controller;
use Home\myLib\JSSDK;

class IntroController extends Controller{
    public function index() {
        //weixinSDK
        $jssdk = new JSSDK("wx81a4a4b77ec98ff4", "436e85f53285ed7a0038f448a78fda66"); //cyxbs
        $signPackage = $jssdk->GetSignPackage();
        $this->assign("signPackage", $signPackage);

        $stu = I('get.stu');
        $this->assign('stu', $stu);

        $userInfo = new UserInfo($stu);
        //总分排行榜
        $rankList = $userInfo->getRankList(10);
        $this->assign('rank', $rankList);
        $this->display();
    }
} 