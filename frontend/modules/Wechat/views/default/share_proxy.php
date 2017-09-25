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
    <title>我的代理链接</title>
    
    <link rel="stylesheet" href="/css/weui/weui.min.css">
    <script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
    <script  type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
	<script type="text/javascript">
	window.onload = function(){
        if(isWeiXin()){
            //var tip = document.getElementById("tip");
    		//tip.style.display = 'block';
            //tip[0].innerHTML = window.navigator.userAgent;
        }
    }
	
    $(function(){
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
    	    title: '快来加入血战麻将，零门槛创业 ！', // 分享标题
    	    link: '<?= $shareLink; ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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
    		title: '快来加入血战麻将，零门槛创业 ！', // 分享标题
    	    desc: '零投资 零风险 零门槛 血战麻将代理虚位以待 ~', // 分享描述
    	    link: '<?= $shareLink; ?>', // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
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

    

</script>
</head>

<body>
<div id="contents">
	<?php if( $isProxyBd ): ?>
	<link rel="stylesheet" href="/css/game_css.css">
	<div class="banner"><img src="/images/banner.png"></div>
    <div style="margin: 7px; background:#5d130a"><p class="p_desc" >【<?=$uObj->nickname ?>】！您可以通过分享本页链接或者下方二维码的方式，发展下级代理，扩大业绩基数。</p></div>
    <?php if( $imageUrl ):?>
    <div class="icon_ma">
        <div class="erweima" style="width: 70%; float: none;">
        	<img id="share_img" src="<?php echo $imageUrl?>" />
        </div>
    </div>
    <?php endif;?>
    <div id="tip" style="display: block">
		<div class="share_text" ><p style="padding:0">点这里分享给您的朋友</p></div>
		<div class="div_btn"><button class="btn_know">知道了</button></div>
		<img src="/images/arrow.png">
	</div>
    <?php elseif($uObj->is_bd):?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">操作失败</h2>
            <p class="weui-msg__desc">抱歉，您目前的代理等级是推广员 ，无法发展下级代理。 请与您的上级代理沟通调整您的返利额度。</p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="/Wechat/default/share-page?id=<?= $uObj->id ?>" class="weui-btn weui-btn_primary">去邀请玩家</a>
            </p>
        </div>
    </div>
    <?php else:?>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">操作失败</h2>
            <p class="weui-msg__desc">抱歉，您还是玩家 ，无法发展下级代理哦。</p>
        </div>
    </div>
    <?php endif;?>
</div>

</body>
<style>
.p_desc{
	text-align: center;   
	color: floralwhite; 
	font-family: 微软雅黑;
	padding-left: 20px;
    padding-right: 20px;
}
.share_text{
	padding: 20px;
    margin-top: 192px;
    background: none;
    padding: 0;
    text-align: center;
    font-size: 30px;
    font-family: 微软雅黑;
    margin-bottom: 0;
}
.div_btn{
	background-image:  url(/images/btn-back.png);
        height: 45px;
        margin-left: 90px;
        margin-right: 90px;
        border-radius: 4.6rem;
        font-size: 25px;
        font-family: 微软雅黑;
        color: white;
}
.btn_know{
	width: 100%;
    height: 100%;
    background: none;    
    border-radius: 4.6rem;
    font-size: 25px;
    font-family: 微软雅黑;
    color: white;
}
</style>
</html>
