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
        $notIN['id'] = array('NOT IN',$link_array);
        $in['id'] = array('IN',$link_array);
        if(!$link_array) {
            $notIN = array();//如果没有链接产品,那么未连接的是全部产品,使用该条件将查询出所有产品
            $in = array('id'=>0);//如果没有链接产品,那么连接产品是空,使用该条件将查询出空数据
        }
        $linkInfo['unlinked'] = M('project_token')->where($notIN)->select();
        $linkInfo['linked'] = M('project_token')->where($in)->select();
        return $linkInfo;
    }

    public function changLink($type,$linkId){
        $old_link = $this->getLink();
        $where['stu_num'] = session('stunum');
        if($type == 'add'){
            if(!$old_link['linked'])
                $save_data['link_id'] = json_encode(array($linkId));
            else{
                $save = array();
                foreach ($old_link['linked'] as $item) {
                    $save[] = $item['id'];
                }
                $save[] = $linkId;
                $save_data['link_id'] = json_encode($save);

            }
            M('user_member')->where($where)->save($save_data);
            return true;
        }
        if($type == 'del'){
            $save = array();
            foreach($old_link['linked'] as $item){
                if($linkId != $item['id'])
                    $save[] = $item['id'];
            }
            $save_data['link_id'] = json_encode($save);
            M('user_member')->where($where)->save($save_data);
            return true;
        }

    }



}

