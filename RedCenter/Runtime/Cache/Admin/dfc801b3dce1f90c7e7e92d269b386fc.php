<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>登录页面_会员中心</title>
    <script src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-1.11.1.js"></script>
    <link rel="stylesheet" href="/RedCenter/RedCenter/Admin/Public/css/style.default.css" type="text/css" />
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-1.7.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.cookie.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/plugins/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="/RedCenter/RedCenter/Admin/Public/js/custom/general.js"></script>
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

<body class="loginpage">
<div class="loginbox">
    <div class="loginboxinner">

        <div class="logo">
            <h1 class="logo">RedCenter.<span>Admin</span></h1>
            <span class="slogan">后台管理系统</span>
        </div><!--logo-->

        <br clear="all" /><br />

        <div class="nousername" id="noname">
        </div><!--nousername-->

        <form id="login" action="<?php echo U('Admin/Login/login', '', '');;?>" method="post">

            <div class="username">
                <div class="usernameinner">
                    <input type="text" name="username" id="username" />
                </div>
            </div>

            <div class="password">
                <div class="passwordinner">
                    <input type="password" name="password" id="password" />
                </div>
            </div>

            <button type="submit">登录</button>

            <!--<div class="keep"><input type="checkbox" /> 记住密码</div>-->

        </form>

    </div><!--loginboxinner-->
</div><!--loginbox-->

</body>
</html>