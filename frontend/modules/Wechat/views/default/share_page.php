<!DOCTYPE html>
<?php
//微信SDK
use common\components\JSSDK;
$signPackage = JSSDK::getInstance( Yii::$app->params['AppId'], Yii::$app->params['AppSecret'] )->getSignPackage();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>我的专属链接</title>
    <link rel="stylesheet" href="/css/game_css.css">
    <script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
    <script  type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
	<script type="text/javascript">
	window.onload = function(){
        if(isWeiXin()){
            var tip = document.getElementById("tip");
    		tip.style.display = 'block';
            //tip[0].innerHTML = window.navigator.userAgent;
        }
    }
    $().ready(function () {
            $("#tip").click(function () {
                $(this).hide();
            });
    });
    function isWeiXin(){
        var ua = window.navigator.userAgent.toLowerCase();
        if(ua.match(/MicroMessenger/i) == 'micromessenger'){
            return true;
        }else{
            return false;
        }
    }
    function func() {
        if(tip.style.display == "block")
            tip.style.display = "none";
        else
            tip.style.display = "block";
    }

    wx.config({
        debug: false,
        appId: '<?php echo $signPackage["appId"];?>',
        timestamp: <?php echo $signPackage["timestamp"];?>,
        nonceStr: '<?php echo $signPackage["nonceStr"];?>',
        signature: '<?php echo $signPackage["signature"];?>',
        jsApiList: [
          // 所有要调用的 API 都要加到这个列表中
			'onMenuShareTimeline',
			'onMenuShareAppMessage'
        ]
    });
    
    wx.ready(function () {
    	// 分享到朋友圈
    	wx.onMenuShareTimeline({
    	    title: '快和我来玩<?php echo $gInfo->title; ?> ！', // 分享标题
    	    link: document.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    	    imgUrl: '<?php echo Yii::$app->urlManager->createAbsoluteUrl('/images/mj_wx_logo.png'); ?>', // 分享图标
    	    success: function () { 
    	        // 用户确认分享后执行的回调函数
    	    	//alert('share ok');
        	},
    	    cancel: function () { 
    	        // 用户取消分享后执行的回调函数
    	    }
    	});

    	// 分享给朋友
    	wx.onMenuShareAppMessage({
    		title: '快和我来玩<?php echo $gInfo->title; ?> ！', // 分享标题
    	    desc: '我玩很久了，值得推荐给你，一起来玩吧~', // 分享描述
    	    link: document.location.href, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
    	    imgUrl: '<?php echo Yii::$app->urlManager->createAbsoluteUrl('/images/mj_wx_logo.png'); ?>', // 分享图标
    	    success: function () { 
    	    	// 用户确认分享后执行的回调函数
    	    	//alert('share ok');
    	    },
    	    cancel: function () { 
    	        // 用户取消分享后执行的回调函数
    	    }
    	});
    });

    /**
     * 获取专属二维码
     */
	function getQrCode( id, callback ){
		$.ajax({
			url:'/Wechat/default/get-qr-code?id='+id,
			success:function( data ){
				var data  = eval("("+data+")");
				callback( data );
			}
	    });
	}
	getQrCode( '<?= yii::$app->request->get('id', 1); ?>' , function( data ){
		$("#share_img").attr("src" ,data.pic_url );
	});
</script>
<style>
.erweima1 {
    width: 64%;
	padding: o;
}
</style>
</head>

<body>
<div id="contents">
	<div class="banner"><img src="/images/banner.png"></div>
	<div style="margin: 7px;"><p style="text-align: center;   color: floralwhite; font-family: 微软雅黑;">请长按下方二维码 识别并下载游戏！</p></div>
	<?php if( $uObj ): ?>
    <div class="icon_ma">
    	<div class="icon">
        	<a class="android" href="<?php echo $gInfo->android_url; ?>" ><img src="/images/android_icon.png"></a>
            <a class="iphone" href="<?php echo $gInfo->ios_url; ?>" id="JdownApp" ><img src="/images/iphone_icon.png"></a>
        </div>
        <div class="erweima">
        	<img id="share_img" src="" />
        </div>
    </div>
    <?php else:?>
    <div class="icon_ma">
        <div class="erweima" style="width: 70%; float: none;">
        	<img id="share_img" src="" />
        </div>
    </div>
    <?php endif;?>
    <div id="tip" style="display: none">
			<p>如果没有自动跳转，可能是微信限制了第三方应用的跳转。</p>
			<p>1. 点击右上角的…</p>
			<p>2. 选择在浏览器中打开</p>
			<img src="/images/arrow.png">
	</div>
</div>

</body>

</html>
