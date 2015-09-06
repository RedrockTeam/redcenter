<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>会员中心</title>
    <link rel="stylesheet" href="/RedCenter/RedCenter/Admin/Public/css/style.default.css" type="text/css" />
</head>
<body class="withvernav">
<div class="bodywrapper">
    <div class="topheader">
        <div class="left">
            <h1 class="logo">REDROCK.<span>会员中心</span></h1>
            <span class="slogan">后台管理系统</span>
            <div class="search">
                <form action="" method="post">
                    <input type="text" name="keyword" id="keyword" value="请输入" />
                    <button class="submitbutton"></button>
                </form>
            </div><!--search-->
            <br clear="all" />
        </div><!--left-->
        <div class="right">
            <div class="userinfo">
                <img src="/RedCenter/RedCenter/Admin/Public/images/thumbs/avatar.png" alt="" />
                <span>管理员</span>
            </div><!--userinfo-->
            <div class="userinfodrop">
                <div class="avatar">
                    <a href=""><img src="/RedCenter/RedCenter/Admin/Public/images/thumbs/avatarbig.png" alt="" /></a>
                    <div class="changetheme">
                        切换主题: <br />
                        <a class="default"></a>
                        <a class="blueline"></a>
                        <a class="greenline"></a>
                        <a class="contrast"></a>
                        <a class="custombg"></a>
                    </div>
                </div><!--avatar-->
                <div class="userdata">
                    <h4><?php echo ($user_name); ?></h4>
                    <span class="email"><?php echo ($user_email); ?></span>
                    <ul>
                        <li><a href="editprofile.html">编辑资料</a></li>
                        <li><a href="accountsettings.html">账号设置</a></li>
                        <li><a href="help.html">帮助</a></li>
                        <li><a href="<?php echo U('Admin/Index/logout');;?>">退出</a></li>
                    </ul>
                </div><!--userdata-->
            </div><!--userinfodrop-->
        </div><!--right-->
    </div><!--topheader-->

    <div class="header">
        <ul class="headermenu">
            <li class="current"><a href="<?php echo U('Admin/Index/index');?>"><span class="icon icon-flatscreen"></span>首页</a></li>
            <li><a href="<?php echo U('Admin/Rbac/index');?>"><span class="icon icon-pencil"></span>用户权限</a></li>
            <li><a href="messages.html"><span class="icon icon-message"></span>应用管理</a></li>
            <li><a href="reports.html"><span class="icon icon-chart"></span>积分管理</a></li>
        </ul>
    </div><!--header-->

    <div class="vernav2 iconmenu">
        <ul>
            <li><a href="#formsub" class="editor">用户权限</a>
                <span class="arrow"></span>
                <ul id="formsub">
                    <li><a href="<?php echo U('Admin/Rbac/index');?>">用户列表</a></li>
                    <li><a href="<?php echo U('Admin/Rbac/role');?>">权限列表</a></li>
                    <li><a href="<?php echo U('Admin/Rbac/node');?>">节点列表</a></li>
                </ul>
            </li>
            <li><a href="#project" class="elements">应用管理</a>
                <span class="arrow"></span>
                <ul id="project">
                    <li><a href="forms.html">应用列表</a></li>

                </ul>
            </li>
            <li><a href="#integral" class="support">积分管理</a>
                <span class="arrow"></span>
                <ul id="integral">
                    <li><a href="<?php echo U('Admin/Score/scoreDetail');?>">积分细则</a></li>
                    <li><a href="<?php echo U('Admin/Score/scoreLevel');?>">积分等级</a></li>

                </ul>
            </li>
        </ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->
    <div class="centercontent">
            
<div class="pageheader">
    <h1 class="pagetitle">用户管理</h1>
    <span class="pagedesc">权限列表</span>
    <a href="<?php echo U('Admin/Rbac/addRole');?>" class="btn btn_bulb" style="float: right; margin: 0 20px;"><span>新增权限</span></a>
</div><!--pageheader-->
<div id="contentwrapper" class="contentwrapper">

<div id="updates" class="subcontent">
<div class="notibar announcement">
    <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
        <colgroup>
            <col class="con0" style="width: 4%" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
            <col class="con0" />
            <col class="con1" />
            <col class="con0" />
        </colgroup>
        <thead>
        <tr>
            <th class="head0"><input type="checkbox" class="checkall" /></th>
            <th class="head1">#</th>
            <th class="head0">name</th>
            <th class="head1">remark</th>
            <th class="head0">status</th>
            <th class="head0">&nbsp;handle</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th class="head0"><input type="checkbox" class="checkall" /></th>
            <th class="head1">#</th>
            <th class="head0">name</th>
            <th class="head1">remark</th>
            <th class="head0">status</th>
            <th class="head0">&nbsp;handle</th>
        </tr>
        </tfoot>
        <tbody>
        <?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td align="center"><input type="checkbox" /></td>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo ($vo["remark"]); ?></td>
            <td class="center"><?php echo ($vo["status"]); ?></td>
            <td class="center"><a href="<?php echo U('Admin/Rbac/access', array('rid' => $vo[id]));?>">修改权限</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo U('Admin/Rbac/deleteRole', array('rid' => $vo[id]));?>">删除</a></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div><!-- notification announcement -->
<div class="two_third dashboard_left">

</div><!--two_third dashboard_left -->
<div class="one_third last dashboard_right">

</div><!--one_third last-->
</div><!-- #updates -->
<div id="activities" class="subcontent" style="display: none;">
    &nbsp;
</div><!-- #activities -->
</div><!--contentwrapper-->
<br clear="all" />
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/general.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/tables.js"></script>
<!--[if IE 9]>
<link rel="stylesheet" media="screen" href="/RedCenter/RedCenter/Admin/Public/css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
<link rel="stylesheet" media="screen" href="/RedCenter/RedCenter/Admin/Public/css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
<script src="/RedCenter/RedCenter/Admin/Public/js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
        <br clear="all" />
    </div><!-- centercontent -->
</div><!--bodywrapper-->
</body>
</html>