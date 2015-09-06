<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/17
 * Time: 18:50
 */
namespace Admin\Controller;
use Think\Controller;

class ScoreController extends CommonController {

    /**
     * 积分细则
     */
    public function scoreDetail(){
        $rule = $this->getRule();
//dd($rule);
        $this->assign('pro', $rule);
        $this->display();
    }

    /**
     * 更改用户行为
     */
    public function setAction(){
        dd(I('id'));
    }

    /**
     * 删除用户行为
     */
    public function deleteAction(){
        dd(I('id'));
    }

    private function getRule(){
        $pro = M('project_token')->select();
        $re = array();
        foreach($pro as $each){
            $relationid = M('action_project')->field('action_id')->where(array('project_id' => $each['id']))->select();
            $each['rule'] = array();

            foreach($relationid as $reid){
                $reid['action_id'];
                $description = M('action')->field('id, description,once, limit_day')->where(array('id' => $reid['action_id']))->find();
                array_push($each['rule'], $description);
            }
            array_push($re, $each);
        }

        return $re;
    }

    /**
     * 积分等级
     */
    public function scoreLevel(){
        $this->display();
    }
}