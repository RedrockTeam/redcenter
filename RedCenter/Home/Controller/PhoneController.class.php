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
        /*var_dump($signPackage);
        array (size=6)
            'appId' => string 'wx81a4a4b77ec98ff4' (length=18)
            'nonceStr' => string 'zfS8FmYAN597zmbp' (length=16)
            'timestamp' => int 1449832108
            'url' => string 'http://localhost/redcenter/index.php/Home/Newphone/index' (length=56)
            'signature' => string 'f8f935c7844141574f33335c2fd98b38c17f8961' (length=40)
            'rawString' => string 'jsapi_ticket=&noncestr=zfS8FmYAN597zmbp&timestamp=1449832108&url=http://localhost/redcenter/index.php/Home/Newphone/index' (length=121)
        */
        //判断方法
        if(IS_POST){
            $stunum = I('post.stu');
        }else{
            //根据stunum获取个人信息和总分数
            $stunum = I('get.stu');
        }
$stunum = '2014211547';
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

   /* //年度积分：
        //1.目前还只有微信应用
        $weixinInfo = M('user_log')->where(array('user_id' => $info['id'], 'project' => '微信'))->select();
        $weixinScore = 0;
        foreach($weixinInfo as $value){
            $weixinScore = $value[score]+$weixinScore;
        }
        //2.查询在BT的积分
        //3.查询在拾货的积分
        //4.查询在锦瑟南山的积分
        //5.查询在掌上重邮的积分

    //月度积分:
        //1.目前还只有微信应用
        $thisMonth = date('m');
        $thisYear = date('Y');
        $month_days = date('t',strtotime($thisYear.'-'.$thisMonth.'-01'));    //本月的最后一天是几号
        $month_start =  mktime(0,0,0,$thisMonth,1,$thisYear);
        $month_end = mktime(23,59,59,$thisMonth,$month_days,$thisYear);
        $time['create_time'] = array('BETWEEN',"$month_start,$month_end");
        $weixinInfo = M('user_log')->where(array('user_id' => $info['id'], 'project' => '微信'))->where($time)->select();
        $weixinScore_month = 0;
        foreach($weixinInfo as $value){
            $weixinScore_month = $value[score]+$weixinScore_month;
        }*/
        //2.查询在BT的积分
        //3.查询在拾货的积分
        //4.查询在锦瑟南山的积分
        //5.查询在掌上重邮的积分

        //年度积分排行榜（前10）  暂没用到
        //$rankList = $userInfo->getRankList(10);
        //月度积分排行榜（前10）  本期新需求
        $rankList_month = $userInfo->getRankList_month(10);
        
        //排名变化
        $rankchange = $userInfo->rankChange();

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
            $this->assign('rankList_month', $rankList_month);
            $this->assign('info', $info);
            $this->assign('rankchange',$rankchange);
            $this->assign('all_scores',$userInfo->getAllScore());
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