<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/16
 * Time: 11:24
 */
namespace Admin\Model;
use Think\Model\RelationModel;
/**
 * 不同项目与积分方法关联模型
 *
 *	**发送多条SQL语句,视图模型用join只发送一条SQL语句**
 */
class ProjectRelationModel extends RelationModel{

    //定义主表名称
    Protected $tableName = 'project_token';

    /*
    *	**HAS_ONE 一对一关系**
    *	**HAS_MANY 一对多关系**
    *	**MANY_TO_MANY 多对多关系**
    */
    //定义关联关系
    Protected $_link = array(
        'action' => array(
            'mapping_type' => self::MANY_TO_MANY,
            'foreign_key' => 'project_id',				//主表在中间表中的字段名称
            'relation_foreign_key' => 'action_id',	    //副表在中间表中的字段名称
            'relation_table' => 'action_project',		//中间表名称(如果有前缀要记得加)
            'mapping_fields' => 'description, once'
        )
    );
}
?>