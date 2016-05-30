<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/15
 * Time: 13:34
 */
namespace Home\myLib;
use \Think\Model;
class UserInfo {

    private $stunum;
    private $info;
    private $uid;
    public function __construct($stunum){
        //获取学号长度, 如果是9位, 判断是否是留学生
        $len = strlen($stunum);
        if($len == 9){
            $this->stunum = 'S'.$stunum;
        }else{
            $this->stunum = $stunum;
        }
        $this->info = M('user_member')->where(array('stu_num' => $this->stunum))->find();
        $this->uid = $this->info['id'];
        $this->updateRank();
        $this->info = M('user_member')->where(array('stu_num' => $this->stunum))->find();
        $this->info['level'] = $this->getLevel();
    }

    public function getSelfInfo(){
//      $this->info['level'] = $this->getLevel($this->info['experience']);
        $this->info['last_time']= date('Y/m/d',$this->info['last_login_time']);
        $this->info['headImage'] = $this->getHeadImg();
        unset($this->info['stu_idcard']);
        unset($this->info['password']);
        return $this->info;
    }

    public function basicInfo(){
        return array(
            'nickname' => $this->info['nickname'],
            'hedimg' => $this->getHeadImg(),
            'myshop' => $this->myshop,
            'mysign' => $this->mysign
        );
    }

    //获取积分
    public function getAllScore(){
        //$projects = array('weixin'=>'微信','BTdown'=>'BTdown铺','market'=>'拾货','jsns'=>'锦瑟南山','zscy'=>'掌上重邮');
        $project_token = M('project_token')->select();
        $projects = array();
        foreach ($project_token as $value) {
            $projects[$value['project_id']] = $value['project'];
        }
        $thisMonth = date('m');
        $thisYear = date('Y');
        $month_days = date('t',strtotime($thisYear.'-'.$thisMonth.'-01'));    //本月的最后一天是几号
        $month_start =  mktime(0,0,0,$thisMonth,1,$thisYear);
        $month_end = mktime(23,59,59,$thisMonth,$month_days,$thisYear);
        $year_start = mktime(0,0,0,1,1,$thisYear);
        $year_end = mktime(23,59,59,12,31,$thisYear);
        $all_scores = array();
    //月度积分
        $time['create_time'] = array('BETWEEN',"$month_start,$month_end");
        $all_scores['byMonth']['total'] = 0;
        foreach ($projects as $key => $value) {
            $logs = M('user_log')->where(array('user_id' => $this->info['id'], 'project' => "$value"))->where($time)->select();
            $all_scores['byMonth']["$key"] = 0;
            foreach ($logs as $once) {
                $all_scores['byMonth']["$key"] += $once['score'];
                if($all_scores['byMonth']["$key"] <0 )    $all_scores['byMonth']["$key"] = 0;
            }
            $all_scores['byMonth']['total'] += $all_scores['byMonth']["$key"]; 
        }
    //年度积分
        $time['create_time'] = array('BETWEEN',"$year_start,$year_end");
        $all_scores['byYear']['total'] = 0;
        foreach ($projects as $key => $value) {
            $logs = M('user_log')->where(array('user_id' => $this->info['id'], 'project' => "$value"))->where($time)->select();
            $all_scores['byYear']["$key"] = 0;
            foreach ($logs as $once) {
                $all_scores['byYear']["$key"] += $once['score'];
                if($all_scores['byYear']["$key"] <0 )     $all_scores['byYear']["$key"] = 0;
            }
            $all_scores['byYear']['total'] += $all_scores['byYear']["$key"];

        }
        
         return $all_scores;
    }

    public function socre_test(){
        $project_token = M('project_token')->select();
        $projects = array();
        foreach ($project_token as $value) {
            $projects[$value['project_id']] = $value['project'];
        }
        $thisMonth = date('m');
        $thisYear = date('Y');
        $month_days = date('t',strtotime($thisYear.'-'.$thisMonth.'-01'));    //本月的最后一天是几号
        $month_start =  mktime(0,0,0,$thisMonth,1,$thisYear);
        $month_end = mktime(23,59,59,$thisMonth,$month_days,$thisYear);
        $year_start = mktime(0,0,0,1,1,$thisYear);
        $year_end = mktime(23,59,59,12,31,$thisYear);
        $all_scores = array();
        //月度积分
        $time['create_time'] = array('BETWEEN',"$month_start,$month_end");
        $all_scores['byMonth']['total'] = 0;
//        foreach ($projects as $key => $value) {
//            $logs = M('user_log')->where(array('user_id' => $this->info['id'], 'project' => "$value"))->where($time)->select();
//            $all_scores['byMonth']["$key"] = 0;
//            foreach ($logs as $once) {
//                $all_scores['byMonth']["$key"] += $once['score'];
//                if($all_scores['byMonth']["$key"] <0 )    $all_scores['byMonth']["$key"] = 0;
//            }
//            $all_scores['byMonth']['total'] += $all_scores['byMonth']["$key"];
//        }   //,'create_time'=>array('BETWEEN',"$month_start,$month_end")
        foreach($projects as $key => $value) {
            $one_score = M('user_log')->where(array('user_id' => $this->info['id'], 'project' => "$value" ))->sum('score');
            $all_scores['byMonth']["$key"]  = $one_score ? $one_score : 0;
            $all_scores['byMonth']['total'] += $all_scores['byMonth']["$key"];
        }


        //年度积分
        $time['create_time'] = array('BETWEEN',"$year_start,$year_end");
        $all_scores['byYear']['total'] = 0;
//        foreach ($projects as $key => $value) {
//            $logs = M('user_log')->where(array('user_id' => $this->info['id'], 'project' => "$value"))->where($time)->select();
//            $all_scores['byYear']["$key"] = 0;
//            foreach ($logs as $once) {
//                $all_scores['byYear']["$key"] += $once['score'];
//                if($all_scores['byYear']["$key"] <0 )     $all_scores['byYear']["$key"] = 0;
//            }
//            $all_scores['byYear']['total'] += $all_scores['byYear']["$key"];
//
//        }
        foreach($projects as $key => $value) {
            $one_score = M('user_log')->field('SUM(score) as total')->where(array('user_id' => $this->info['id'], 'project' => "$value", 'create_time'=>array('BETWEEN',"$year_start,$year_end")))->find();
            $all_scores['byYear']["$key"]  = $one_score['total'] ? $one_score['total'] : 0;
            $all_scores['byYear']['total'] += $all_scores['byYear']["$key"];
        }

        return $all_scores;
    }

    //在首页展示排名时,此次排名与上次的可能发生变化.应先通过比较分数获取新排名,更新到数据库
    public function updateRank(){
        //$where['score'] = array('EGT',$this->info['score']);
        //$res = M('user_member')->where($where)->order('score desc,score_update_time ')->select();
        $M = new \Think\Model(); $res = $M->query("select stu_num from user_member where score >=".$this->info['score']." ORDER BY score DESC ,score_update_time ASC ");
        $i = 1;
        foreach ($res as $value) {
            if($value['stu_num'] != $this->stunum)
                $i++;
            else
                break;
        }
        $save['year_rank'] = $i;

        //$where['score_month'] = array('EGT',$this->info['score_month']);
        //$res = M('user_member')->where($where)->order('score_month desc,score_update_time ')->select();
        $M = new \Think\Model(); $res = $M->query("select stu_num from user_member where score_month >=".$this->info['score_month']." ORDER BY score_month DESC ,score_update_time ASC ");
        $i = 1;
        //echo "本人学号:".$this->stunum."foreach前排名:".$this->info['month_rank']."\n";
        foreach ($res as $value) {
          //  echo "第".$i."次,学号:".$value['stu_num'].",";
            if($value['stu_num'] != $this->stunum)
                $i++;
            else
                break;
            //echo "执行一次后:".$i."\n";
        }
        $save['month_rank'] = $i;
        $save['id'] = $this->uid;
        M('user_member')->save($save);
        //echo "最后排名:".$i."=".$save['month_rank'];
    }

    //获取该年排名
    public function getSelfRank(){
        $where['score'] = array('EGT',$this->info['score']);
        $res = M('user_member')->where($where)->order('score desc,score_update_time ')->select();
        $i = 1;
        foreach ($res as $value) {
            if($value['stu_num'] != $this->stunum)
                $i++;
            else
                break;
        }
        return $i;   
    }

    //获取该月排名
    public function getSelfRank_month(){
        $where['score_month'] = array('EGT',$this->info['score_month']);
        $res = M('user_member')->where($where)->order('score_month desc,score_update_time ')->select();
        $i = 1;
        foreach ($res as $value) {
            if($value['stu_num'] != $this->stunum)
                $i++;
            else
                break;
        }
        return $i;   
    }

    //获取排名变化
    public function rankChange(){
        $last_month_rank = $this->info['last_month_rank'];
        $last_year_rank = $this->info['last_year_rank'];
        $change['rankchange_month'] = $this->info['last_month_rank']==0 ? 0 : $this->info['last_month_rank'] - $this->info['month_rank']; 
        $change['rankchange_year'] = $this->info['last_year_rank']==0 ? 0 : $this->info['last_year_rank'] - $this->info['year_rank'];
        $change['month_src'] = $change['rankchange_month'] >= 0 ? 'rose.png' : 'decline.png';
        $change['year_src'] = $change['rankchange_year'] >= 0 ? 'rose.png' : 'decline.png';
        return $change;
    }


    //获取年度积分排行    本期暂时没用到
    public function getRankList($num = null){
        $need_fields = 'stu_num,nickname,real_name,month_rank,score_month,last_month_rank';
        if(is_null($num)){
            $rankList = M('user_member')->field($need_fields)->where(array('score'=>array('GT',0)))->order('score desc,score_update_time ')->limit(10)->select();
        }else{
            $rankList = M('user_member')->field($need_fields)->where(array('score'=>array('GT',0)))->order('score desc,score_update_time ')->limit($num)->select();
        }
        $re = array();
        foreach($rankList as $key => $each){
            if($each['score'] == 0 || $each['score'] < 0)
                unset($rankList["$key"]);
            else{
                $level = $this->getLevel($each['experience']);
                $each['level'] = $level;
                $each['num'] = $key + 1;
                array_push($re, $each);
            }
        }

        return $re;
    }

    //获取每月积分排行   本期的新需求
    public function getRankList_month($num = null){
        $need_fields = 'stu_num,nickname,real_name,month_rank,score_month,last_month_rank';
        if(is_null($num)){
            $result = M('user_member')->field($need_fields)->where(array('score_month'=>array('GT',0)))->order('score_month desc,score_update_time ')->limit(10)->select();
        }else{
            $result = M('user_member')->field($need_fields)->where(array('score_month'=>array('GT',0)))->order('score_month desc,score_update_time ')->limit($num)->select();
        }
//        $rankList_month = array();
//        foreach ($result as $key => $each) {
//            if($each['score_month'] == 0 || $each['score_month'] < 0)
//                unset($result["$key"]);
//            else{
//                $level = $this->getLevel($each['experience']);
//                $each['level'] = $level;
//                $each['num'] = $key + 1;
//                array_push($rankList_month, $each);
//            }
//        }

        return $result;
    }  

    //同于PC端头像
    public function getHeadImg(){
        $headImage = 'head_img/'.$this->info['headimg'];
        if($this->info['headimg'] == ""){
            if($this->info['gender'] == "男" or $this->info['gender'] == "m"){
                $headImage = "head_img/m.png";
            }elseif($this->info['gender'] == "女" or $this->info['gender'] == "f"){
                $headImage = "head_img/f.png";
            }
        }
        return $headImage;
    }

    public function getLog($num = null, $project = null){
        if(is_null($project)){
            if(is_null($num)){
                $log = M('user_log')->where(array('user_id' => $this->uid))->order('id desc')->limit(10)->select();
            }else{
                $log = M('user_log')->where(array('user_id' => $this->uid))->order('id desc')->limit($num)->select();
            }
            $logCount = M('user_log')->where(array('user_id' => $this->uid))->count();
        }else{
            if(is_null($num)){
                $log = M('user_log')->where(array('user_id' => $this->uid, 'project' => $project))->order('id desc')->select();
            }else{
                $log = M('user_log')->where(array('user_id' => $this->uid, 'project' => $project))->order('id desc')->limit($num)->select();
            }
            $logCount = M('user_log')->where(array('user_id' => $this->uid, 'project' => $project))->count();
        }

        return array(
            'logCount' => $logCount,
            'log' => $log
        );
    }

    public function getRule($project = null){
        $pro = M('project_token')->select();
        $re = array();
        foreach($pro as $each){
            $relationid = M('action_project')->field('action_id')->where(array('project_id' => $each['id']))->select();
            $each['rule'] = array();

            foreach($relationid as $reid){
                $reid['action_id'];
                $description = M('action')->field('description,once')->where(array('id' => $reid['action_id']))->find();
                array_push($each['rule'], $description);
            }
            array_push($re, $each);
        }
        if(is_null($project)){
            return $re;
        }else{
            foreach($re as $ea){
                if($ea['project'] == $project){
                    return $ea['rule'];
                }
            }

            return false;
        }
    }

    public function getLevel($experience = null){
        if(is_null($experience)){
            $experience = $this->info['experience'];
        }
        $map['min_experience']  = array('ELT',$experience);
        $map['max_experience']  = array('EGT',$experience);
        $res = M('user_level')->where($map)->find();

        return $res['level'];
    }

    //获取等级明细
    public function getLevelRule(){
        $levelRule = M('user_level')->select();

        return $levelRule;
    }

    //获取帮助中心的文章
    public function getHelp($page){
        $link = json_decode($this->info['link_id']);
        $link[] = 0;  //pro_id = 0,表示文章所有人可见,
        $where['pro_id'] = array('IN',$link);
        $total = M('help_center')->where($where)->count();
        $begin = $page ? ($page-1)*6 : 0;
        $help = M('help_center')->where($where)->order('time desc')->limit($begin,6)->select();
        $num['stu_num'] = $this->stunum;
        $save['read_help'] = $total;
        M('user_member')->where($num)->save($save);
        $res['total'] = $total;
        $res['article'] = $help;
        return $res;
    }

    //获取消息
    public function getNew($page){
        $link = json_decode($this->info['link_id']);
        $link[] = 0;//pro_id = 0,表示文章所有人可见,
        $where['pro_id'] = array('IN',$link);
        $total = M('new_center')->where($where)->count();
        $begin = $page ? ($page-1)*5 : 0;
        $new = M('new_center')->where($where)->order('time desc')->limit($begin,5)->select();
        $num['stu_num'] = $this->stunum;
        $save['read_news'] = $total;
        M('user_member')->where($num)->save($save);
        $res['total'] = $total;
        $res['article'] = $new;
        return $res;
    }

    //新发布的未读的帮助文章数目
    public function newHelpNum(){
        $link = json_decode($this->info['link_id']);
        $link[] = 0;
        $where['pro_id'] = array('IN',$link);
        $total = M('help_center')->where($where)->count();
        $tmp = M('user_member')->where(array('stu_num'=>$this->stunum))->find();
        $read_help = $tmp['read_help'];
        $num = $total - $read_help;
        return $num;
    }

    //新发布的未读的消息数目
    public function newNewsNum(){
        $link = json_decode($this->info['link_id']);
        $link[] = 0;
        $where['pro_id'] = array('IN',$link);
        $total = M('new_center')->where($where)->count('id');
        $tmp = M('user_member')->where(array('stu_num'=>$this->stunum))->find();
        $read_news = $tmp['read_news'];
        $num = $total - $read_news;
        return $num;
    }

    //获取网校产品链接情况
    public function linkInfo(){
        $res = D('Link')->getLink();
        return $res;
    }

    //在个产品上的登录次数
    public function logTime(){
        $ZSCY = M('user_log')->where(array('project'=>'掌上重邮','action'=>'第一次登陆掌上重邮','user_id'=>$this->uid))->count('id');
        $cyxbs = M('user_log')->where(array('project'=>'微信','action'=>'当天第一次使用','user_id'=>$this->uid))->count('id');
        $tmp = M('user_member')->where(array('stu_num'=>$this->stunum))->find();
        $visit_time = $tmp['weixin_visit_num'];
        return array('zscy'=>$ZSCY,'cyxbs'=>$cyxbs,'hyzx'=>$visit_time);
    }
}