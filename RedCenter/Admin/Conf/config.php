<?php
return array(
    //权限验证
    'RBAC_SUPERADMIN'   => '冯秋明',         //超级管理员账号
    'ADMIN_AUTH_KEY'    => 'superadmin',    //超级管理员识别
    'USER_AUTH_ON'      => true,            //是否开启验证
    'USER_AUTH_TYPE'    => 1,               //验证类型(1:登录验证 2:实时验证)
    'USER_AUTH_KEY'     => 'uid',           //用户认证识别号
    'NOT_AUTH_MODULE'   => 'Index',         //无需认证的控制器
    'NOT_AUTH_ACTION'   => 'addUserHandle,setRoleHandle,addRoleHandle,addNodeHandle,setAccess',            //无需认证的工作方法

    //Public文件位置
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__ . '/' . APP_NAME . '/Admin/Public',
    ),

    //伪静态后缀
    'URL_HTML_SUFFIX' => '',
);