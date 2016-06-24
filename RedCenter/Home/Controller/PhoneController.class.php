<?php
namespace Home\Controller;
use Home\myLib\UserInfo;
use Think\Controller;
use Home\myLib\JSSDK;

class PhoneController extends Controller {
    private $appid = 'wx81a4a4b77ec98ff4';
    private $appSecret = '436e85f53285ed7a0038f448a78fda66';
    public function index(){

        $jssdk = new JSSDK($this->appid, $this->appSecret);
        $signPackage = $jssdk->GetSignPackage();
        $this->assign("signPackage", $signPackage);

        if(IS_POST)     $stunum = I('post.stu');            //判断方法
        else            $stunum = I('get.stu');             //根据stunum获取个人信息和总分数

        $userInfo = new UserInfo($stunum);
        $info = $userInfo->getSelfInfo();
        if(!$stunum || !$info['stu_num'])                   //未进行学号绑定的, 跳转至学号绑定页面
            redirect("http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Bind/Bind/bind");
        if($info){              //已经绑定了的用户, 每一次访问时就在微信访问次数上加一
            $data['id'] = $info['id'];
            $data['weixin_visit_num'] = $info['weixin_visit_num']+1;
            M('user_member')->save($data);
        }

        /* if(date('Y/m',$info['score_update_time']) != date('Y/m')){  //该月第一次使用
            $this->firstUse($stunum);
            $userInfo = new UserInfo($stunum);
            $info = $userInfo->getSelfInfo();
        }*/

        //$rankList = $userInfo->getRankList(10);               //年度积分排行榜（前10）  暂没用到
        $rankList_month = $userInfo->getRankList_month(10);     //月度积分排行榜（前10）  本期新需求
        $rankchange = $userInfo->rankChange();                  //年度,月度排名变化数据和排名上升/下降图片的SRC
        $headImage = $info['headimg'] ? 'head_img/'.$info['headimg'] : "img_phone/head.jpg";//获取头像
//        $all_scores = $userInfo->socre_test();                //各个项目年度,月度积分

        if(IS_POST){
            $this->ajaxReturn(array(
                'headImage' => $headImage,
                'rankList_month' => $rankList_month,
//                'all_scores' => $all_scores,
                'rankchange' => $rankchange,
                'info' => $info
            ));
        }else{
            $this->assign('headImage', $headImage);
            $this->assign('rankList_month', $rankList_month);
            $this->assign('info', $info);
            $this->assign('rankchange',$rankchange);
//            $this->assign('all_scores',$all_scores);
            $this->assign('num',1);
            $this->display();
            
//            var_dump($headImage);
//            var_dump($rankList_month);
//            var_dump($info);
//            var_dump($rankchange);
//            var_dump($userInfo->getAllScore());
        }
    }

    public function integral_rule(){
        $this->display();
    }

    public function firstUse($stunum){
        $url = 'http://hongyan.cqupt.edu.cn/RedCenter/Api/Handle/index';
//        $tmpArr = array('cyxbs',"$stunum",'firstUse');
//        sort($tmpArr, SORT_STRING);
//        $t = md5( sha1( implode( $tmpArr, '|' ) ) );
        $token = generateToken('cyxbs',$stunum,'firstUse');
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "type=firstUse&stu=$stunum&id=cyxbs&token=".$token);
        curl_exec($ch);
        //$output = json_decode(curl_exec($ch),TRUE);
    }
}