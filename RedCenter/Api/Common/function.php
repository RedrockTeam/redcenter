<?php
/**
 * 判断是否已经满足今天的加分上限
 */
function isFull($stu_num, $act, $pro){

    //首先用php获取当天的年份
    $y = date("Y");
    //首先用php获取当天的月份
    $m = date("m");
    //首先用php获取当天的号数（也就是几日，那今天来讲就是：11日）
    $d = date("d");
    //将今天开始的年月日时分秒，转换成unix时间戳(开始示例：2014-03-11 00:00:00)
    $day_start = mktime(0,0,0,$m,$d,$y);
    //将今天结束的年月日时分秒，转换成unix时间戳 (结束示例：2014-03-11 23:59:59)
    $day_end= mktime(23,59,59,$m,$d,$y);

    $userid = M('user_member')->where(array('stu_num' => $stu_num))->find()['id'];
    $desc = $act['description'];
    //create_time > ".$day_start." and create_time < ".$day_end." and user_id = ".$userid." and project = ".$pro." and action = ".$desc
    $Model = new \Think\Model();
    $todayLog = $Model->query("select * from user_log where create_time > ".$day_start." and create_time < ".$day_end." and user_id = ".$userid." and project = '".$pro."'and action = '".$desc."'");
    if(!$todayLog){
        return false;
    }
    foreach($todayLog as $each){
        foreach($each as $key => $value){
            if($key == 'score') $todayScore += $value;
        }
    }
    if($todayScore < $act['limit_day']){
        return false;
    }else{
        return true;
    }
}

function generateToken($id, $stu, $action_type){
    $tmpArr = array($id, $stu, $action_type);
    sort($tmpArr, SORT_STRING);
    return md5( sha1( implode( $tmpArr, '|' ) ) );
}