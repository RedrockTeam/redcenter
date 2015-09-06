<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <!--<meta name="description" content="">-->
    <!--<meta name="author" content="">-->
    <!--标题图标-->
    <!--<link rel="icon" href="../../favicon.ico">-->

    <title>登陆</title>

    <!-- Bootstrap core CSS -->
    <link href="/RedCenter/RedCenter/Home/Public/css/bootstrap.min.css" rel="stylesheet">
    <link href="/RedCenter/RedCenter/Home/Public/css/login.css" rel="stylesheet">
</head>

<body>

<!--<div class="container-center">-->
<form id="form_login" class="container-center form-horizontal font_fa" action="<?php echo U('Home/Login/loginHandle', '','');?>" method="post">
    <h1 class="form-heading text-center">会员中心</h1>
    <div class="form-group h4">
        <label for="inputUser" class="form_font control-label col-md-3 col-lg-3 col-sm-3 col-xs-3">账号：</label>
        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
            <input name="user" type="text" id="inputUser" class="form-control" placeholder="学号" required autofocus>
        </div>
    </div>
    <div class="form-group h4">
        <label for="inputPassword" class="form_font control-label col-md-3 col-lg-3 col-sm-3 col-xs-3">密码：</label>
        <div class="col-md-9 col-lg-9 col-sm-9 col-xs-9">
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="ucenter/重邮通行证/身份证后六位" required autofocus>
        </div>
    </div>

    <div class="checkbox clearfix">
        <label class="form_remember">
            <input type="checkbox" value="remember"> 记住密码
        </label>
        <a class="form_forget">忘记密码?</a>
    </div>

    <button class="btn btn-lg btn-primary form_sub center-block" type="submit">登陆</button>
</form>
<div class="complete">
    <div class="complete_bac"></div>
    <form id="form_ask" class="container-center form-horizontal font_fa" action="#" method="post">
        <div class="alert complete_head text-center" role="alert">如修改过密码，请验证密保问题修改密码</div>
        <div class="form-group h4">
            <label for="inputAsk" class="form_font control-label col-md-5 col-lg-5 col-sm-5 col-xs-5">密保问题：</label>
            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-7">
                <!--<input name="ask" type="text" id="inputAsk" class="form-control " required>-->
                <p class="form-control" id="inputAsk">密保问题</p>
            </div>
        </div>
        <div class="form-group h4">
            <label for="inputAns" class="form_font control-label col-md-5 col-lg-5 col-sm-5 col-xs-5">密保答案：</label>
            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-7">
                <input name="answer" type="text" id="inputAns" class="form-control " required>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary col-lg-6 col-md-6 col-sm-6 col-lg-offset-2 col-md-offset-2 col-sm-offset-2" type="submit">确定</button>
            <button class="btn btn-lg btn-primary col-lg-3 col-md-3 col-sm-3 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 btn-warning" type="submit">取消</button>
        </div>
    </form>
    <form id="form_change" class="container-center form-horizontal font_fa" action="#" method="post">
        <div class="alert complete_head text-center" role="alert">如修改过密码，请验证密保问题修改密码</div>
        <div class="form-group h4">
            <label for="inputPass" class="form_font control-label col-md-5 col-lg-5 col-sm-5 col-xs-5">新密码：</label>
            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-7">
                <input name="password" type="text" id="inputPass" class="form-control " required>
            </div>
        </div>
        <div class="form-group h4">
            <label for="inputPass_again" class="form_font control-label col-md-5 col-lg-5 col-sm-5 col-xs-5">确认密码：</label>
            <div class="col-md-7 col-lg-7 col-sm-7 col-xs-7">
                <input name="password_again" type="text" id="inputPass_again" class="form-control " required>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-lg btn-primary col-lg-6 col-md-6 col-sm-6 col-lg-offset-2 col-md-offset-2 col-sm-offset-2" type="submit">确定</button>
            <button class="btn btn-lg btn-primary col-lg-3 col-md-3 col-sm-3 col-lg-offset-1 col-md-offset-1 col-sm-offset-1 btn-warning" type="submit">取消</button>
        </div>
    </form>
</div>

</body>
<script type="text/javascript" src="/RedCenter/RedCenter/Home/Public/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Home/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Home/Public/js/form_check.js"></script>
<script type="text/javascript" src="/RedCenter/RedCenter/Home/Public/js/login.js"></script>
</html>