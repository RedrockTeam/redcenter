<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/15
 * Time: 13:34
 */
namespace Home\myLib;

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
        $user = M('user_member')->where(array('stu_num' => $this->stunum))->find();
        $this->uid = $user['id'];
    }

    public function getSelfInfo(){
        return $this->info;
    }

    //获取排名
    public function getSelfRank(){
        $selfScore = $this->info['score'];
        $map['score'] = array('gt',$selfScore);
        $selfRank = M('user_member')->where($map)->count()+1;

        return $selfRank;
    }

    public function getRankList($num = null){
        if(is_null($num)){
            $rankList = M('user_member')->order('score desc')->select();
        }else{
            $rankList = M('user_member')->order('score desc')->limit($num)->select();
        }
        $re = array();
        foreach($rankList as $each){
            $level = $this->getLevel($each['score']);
            $each['level'] = $level;
            array_push($re, $each);
        }

        return $re;
    }

    public function getHeadImg(){
        if($this->info['headimg'] == ""){
            if($this->info['gender'] == "男" or $info['gender'] == "m"){
                $headImage = "img/m.png";
            }elseif($this->info['gender'] == "女" or $info['gender'] == "f"){
                $headImage = "img/f.png";
            }
        }

        return $headImage;
    }

    public function getLog($num = null, $project = null){
        if(is_null($project)){
            if(is_null($num)){
                $log = M('user_log')->where(array('user_id' => $this->uid))->order('id desc')->select();
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

    public function getLevel($score = null){
        if(is_null($score)){
            $score = $this->info['score'];
        }
        $map['min_score']  = array('ELT',$score);
        $map['max_score']  = array('EGT',$score);
        $level_obj = M('user_level')->where($map)->find();
        $level = $level_obj['level'];
        return $level;
    }

    //获取等级明细
    public function getLevelRule(){
        $levelRule = M('user_level')->select();

        return $levelRule;
    }
}