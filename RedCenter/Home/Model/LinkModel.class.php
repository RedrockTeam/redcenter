<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/16
 * Time: 11:24
 */
namespace Home\Model;
use Think\Model;

class LinkModel extends Model{
    public function getLink()
    {
        $where['stu_num'] = session('stunum');
        $res = M('user_member')->where($where)->find();
        $link_array = json_decode($res['link_id']);
        if(!$res['link_id'])    $link_array = array();
        $notIN['id'] = array('NOT IN',$link_array);
        $linkInfo['unlinked'] = M('project_token')->where($notIN)->select();
        $in['id'] = array('IN',$link_array);
        $linkInfo['linked'] = M('project_token')->where($in)->select();
        return $linkInfo;
    }

    public function changLink($type,$linkId){
        $old_link = $this->getLink();
        $where['stu_num'] = session('stunum');
        if($type == 'add'){
            if(!$old_link['linked'])
                $save = json_encode(array($linkId));
            else{
                $save = array();
                foreach ($old_link['linked'] as $item) {
                    $save[] = $item['id'];
                }
                $save[] = $linkId;
                $save['link_id'] = json_encode($save);
            }
            M('user_member')->where($where)->save($save);
        }
        if($type == 'del'){
            $save = array();
            foreach($old_link['unlinked'] as $item){
                if($linkId != $item['id'])
                    $save[] = $item['id'];
            }
            $save['link_id'] = json_encode($save);
            M('user_member')->where($where)->save($save);
        }

    }



}

