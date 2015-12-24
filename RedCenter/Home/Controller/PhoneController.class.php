<?php
namespace Home\Controller;
use Home\myLib\UserInfo;
use Think\Controller;
use Home\myLib\JSSDK;

class PhoneController extends Controller {
    private $appid = 'wx81a4a4b77ec98ff4';
    private $appSecret = '436e85f53285ed7a0038f448a78fda66';
    public function index(){
        $jssdk = new JSSDK($this->appid, $this->appSecret); //cyxbs
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

        //未进行学号绑定的, 跳转至学号绑定页面
        if(!$stunum || !$info['stu_num']){
            redirect("http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Bind/Bind/bind");
        }

        //已经绑定了的用户, 每一次访问时就在微信访问次数上加一
        if($info){
            $Model = M('user_member');
            $data['id'] = $info['id'];
            $data['weixin_visit_num'] = $info['weixin_visit_num']+1;
            $Model->save($data);
        }

        //年度积分排行榜（前10）  暂没用到
        //$rankList = $userInfo->getRankList(10);

        //月度积分排行榜（前10）  本期新需求
        $rankList_month = $userInfo->getRankList_month(10);
        
        //排名变化
        $rankchange = $userInfo->rankChange();

        //获取头像
        $headImage = $userInfo->getHeadImg();

        //各种积分
        $all_scores = $userInfo->getAllScore();

        if(IS_POST){
            $this->ajaxReturn(array(
                'headImage' => $headImage,
                'rankList_month' => $rankList_month,
                'all_scores' => $all_scores,
                'rankchange' => $rankchange,
                'info' => $info
            ));
        }else{
            $this->assign('headImage', $headImage);
            $this->assign('rankList_month', $rankList_month);
            $this->assign('info', $info);
            $this->assign('rankchange',$rankchange);
            $this->assign('all_scores',$all_scores);
            $this->display();
            //var_dump($headImage);
            //var_dump($rankList_month);
            //var_dump($info);
            //var_dump($rankchange);
            //var_dump($userInfo->getAllScore());
        }
    }

    public function integral_rule(){
        $this->display();
    }
}