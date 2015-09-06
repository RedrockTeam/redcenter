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
            <li><a href="#"><span class="icon icon-message"></span>应用管理</a></li>
            <li><a href="<?php echo U('Admin/Score/scoreDetail');?>"><span class="icon icon-chart"></span>积分管理</a></li>
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
                    <li><a href="#">应用列表</a></li>

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
            
<div id="contentwrapper" class="contentwrapper elements">
<div class="contenttitle2">
    <h3>积分细则</h3>
</div><!--contenttitle-->
<br />

<div id="tabs">
    <ul>
        <?php if(is_array($pro)): foreach($pro as $key=>$vo): ?><li><a href="#tabs-<?php echo ($vo["id"]); ?>"><?php echo ($vo["project"]); ?></a></li><?php endforeach; endif; ?>
    </ul>
    <?php if(is_array($pro)): foreach($pro as $key=>$vo): ?><div id="tabs-<?php echo ($vo["id"]); ?>">
            <table cellpadding="0" cellspacing="0" border="0" class="stdtable">
                <thead>
                <tr>
                    <th class="head0">用户行为</th>
                    <th class="head1">每次加减的分数</th>
                    <th class="head0">一天内的上限</th>
                    <th class="head1">操作</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="head0">用户行为</th>
                    <th class="head1">每次加减的分数</th>
                    <th class="head0">一天内的上限</th>
                    <th class="head1">操作</th>
                </tr>
                </tfoot>
                <tbody>
                <?php if(is_array($vo["rule"])): foreach($vo["rule"] as $key=>$vi): ?><tr>
                    <td><?php echo ($vi["description"]); ?></td>
                    <td><?php echo ($vi["once"]); ?></td>
                    <td><?php echo ($vi["limit_day"]); ?></td>
                    <td class="center">
                        <a href="<?php echo U('Admin/Score/setAction', array('id' => $vi[id]));?>" class="edit">修改信息</a>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="<?php echo U('Admin/Score/deleteAction', array('id' => $vi[id]));?>" class="delete">删除</a>
                    </td>
                </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
        </div><?php endforeach; endif; ?>
</div><!--#tabs-->
</div>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/colorpicker.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.jgrowl.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.alerts.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/general.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/elements.js"></script>
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