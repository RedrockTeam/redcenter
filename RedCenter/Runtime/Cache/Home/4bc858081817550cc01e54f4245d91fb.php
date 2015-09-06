<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/redcenter/RedCenter/Home/Public/css/VIP_phone.css">
    <title>会员中心</title>
</head>
<body>
    <div class="header">
        <div class="header_center">
            <img class="header_logo" src="/redcenter/RedCenter/Home/Public/img/red.png" alt="红岩"/>
            <h1 class="header_title">会员中心</h1>
        </div>
    </div>
    <div class="content">
        <div class="personal_info">
            <div class="basic_info">
                <img class="face" src="/redcenter/RedCenter/Home/Public/<?php echo ($headImage); ?>" alt="头像" />
                <div class="na_nu">
                    <p class="name"><?php echo ($info['nickname']); ?></p>
                    <p class="num"><?php echo ($info['stu_num']); ?></p>
                </div>
            </div>
            <div class="basic_integral">
                <div>
                    <p class="inte_name">总积分</p>
                    <p class="inte_value"><?php echo ($info['score']); ?>分</p>
                </div>
                <div>
                    <p class="inte_name">排名</p>
                    <p class="inte_value">第<?php echo ($self); ?>名</p>
                </div>
            </div>
            <div class="all_detail">
                <div class="detail">
                    <img class="det_img" src="/redcenter/RedCenter/Home/Public/img/talk.png" alt="图标">
                    <p class="det_name">重邮小帮手微信端</p>
                    <p class="det_value"><?php echo ($weixin); ?>分</p>
                </div>
                <div class="detail">
                    <img class="det_img" src="/redcenter/RedCenter/Home/Public/img/bt.png" alt="图标">
                    <p class="det_name">BT down铺</p>
                    <p class="det_value">敬请期待</p>
                </div>
                <div class="detail">
                    <img class="det_img" src="/redcenter/RedCenter/Home/Public/img/sell.png" alt="图标">
                    <p class="det_name">拾货</p>
                    <p class="det_value">敬请期待</p>
                </div>
            </div>
        </div>
        <div class="rank">
            <div class="detail">
                <img class="det_img" src="/redcenter/RedCenter/Home/Public/img/rank.png" alt="排名">
                <p class="det_name">积分排行榜</p>
            </div>
            <?php if(is_array($rank)): $i = 0; $__LIST__ = $rank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="detail">
                    <p class="rank_n"><?php echo ($key+1); ?></p>
                    <p class="det_name rank_name"><?php echo ($vo["nickname"]); ?></p>
                    <p class="det_value"><?php echo ($vo["score"]); ?>分</p>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        wx.config({
            //debug: true,
            appId: '<?php echo ($signPackage["appId"]); ?>',
            timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
            nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
            signature: '<?php echo ($signPackage["signature"]); ?>',
            jsApiList: [
                'hideAllNonBaseMenuItem',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'previewImage'
            ]
        });
        var share = {
            title: "会员中心",
            desc: "会员中心",
            link: "http://hongyan.cqupt.edu.cn/RedCenter/index.php/Intro/",
            img: "http://hongyan.cqupt.edu.cn/RedCenter/RedCenter/Home/Public/img/top.png"
        };
        wx.ready(function () {
            //分享到朋友圈
            wx.onMenuShareTimeline({
                title: share.title, // 分享标题
                link: share.link, // 分享链接
                imgUrl: share.img, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            //分享给朋友
            wx.onMenuShareAppMessage({
                title: share.title, // 分享标题
                desc: share.desc, // 分享描述
                link: share.link, // 分享链接
                imgUrl: share.img, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    </script>
</body>
</html>