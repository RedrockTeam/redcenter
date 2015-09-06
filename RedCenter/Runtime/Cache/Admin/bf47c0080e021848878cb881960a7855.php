<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>会员中心</title>
    <link rel="stylesheet" href="/RedCenter/RedCenter/Admin/Public/css/style.default.css" type="text/css" />
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.cookie.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.flot.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.flot.resize.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/general.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/dashboard.js"></script>
    <!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/excanvas.min.js"></script><![endif]-->
    <!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="/RedCenter/RedCenter/Admin/Public/css/style.ie9.css"/>
    <![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="/RedCenter/RedCenter/Admin/Public/css/style.ie8.css"/>
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="/RedCenter/RedCenter/Admin/Public/js/plugins/css3-mediaqueries.js"></script>
    <![endif]-->
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
            <!--<div class="notification">
                <a class="count" href="ajax/notifications.html"><span>9</span></a>
            </div>-->
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
                    <li><a href="forms.html">积分细则</a></li>
                    <li><a href="forms.html">积分等级</a></li>
                </ul>
            </li>
        </ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->
    <div class="centercontent">
    
        <div class="pageheader">
            <h1 class="pagetitle">用户管理</h1>
            <span class="pagedesc">修改权限</span>
            <a href="<?php echo U('Admin/Rbac/role');?>" class="btn btn_bulb" style="float: right; margin: 0 20px;"><span>返回</span></a>
        </div><!--pageheader-->
        <div id="contentwrapper" class="contentwrapper">

            <div id="updates" class="subcontent">
                <div class="notibar announcement">
                    <form action="<?php echo U('Admin/Rbac/setAccess');?>" method="post">
                        <div id="wrap">
                            <?php if(is_array($node)): foreach($node as $key=>$app): ?><div class="app">
                                    <p>
                                        <strong><?php echo ($app["title"]); ?></strong>
                                        <input type="checkbox" name="access[]" value="<?php echo ($app["id"]); ?>_1" level='1' <?php if($app["access"]): ?>checked = 'checked'<?php endif; ?> />
                                    </p>

                                    <?php if(is_array($app["child"])): foreach($app["child"] as $key=>$controller): ?><dl>
                                            <dt>
                                                <strong><?php echo ($controller["title"]); ?></strong>
                                                <input type="checkbox" name="access[]" value="<?php echo ($controller["id"]); ?>_2" level='2' <?php if($controller["access"]): ?>checked = 'checked'<?php endif; ?> />
                                            </dt>
                                            <?php if(is_array($controller["child"])): foreach($controller["child"] as $key=>$method): ?><dd>
                                                    <span><?php echo ($method["title"]); ?></span>
                                                    <input type="checkbox" name="access[]" value="<?php echo ($method["id"]); ?>_3" level='3' <?php if($method["access"]): ?>checked = 'checked'<?php endif; ?> />
                                                </dd><?php endforeach; endif; ?>
                                        </dl><?php endforeach; endif; ?>
                                </div><?php endforeach; endif; ?>
                        </div>
                        <input type="hidden" name="rid" value="<?php echo ($rid); ?>" />
                        <input type="submit" value="保存修改" style="display:block; margin:20px auto; cursor:pointer;" />
                    </form>
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
<script type="text/javascript">
    $(function(){
        $('input[level=1]').click(function(){
            var inputs = $(this).parents('.app').find('input');
            $(this).attr('checked') ? inputs.attr('checked', 'checked') : inputs.removeAttr('checked');
        });

        $('input[level=2]').click(function(){
            var inputs = $(this).parents('dl').find('input');
            $(this).attr('checked') ? inputs.attr('checked', 'checked') : inputs.removeAttr('checked');
        });
    });
</script>

    </div><!-- centercontent -->
</div><!--bodywrapper-->
</body>
</html>