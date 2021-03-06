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
    <title><?php echo $gInfo->title; ?></title>
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
    		title: '<?php echo $roomInfo['Title'];?>', // 分享标题
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
    		title: '<?php echo $roomInfo['Title'];?>', // 分享标题
    	    desc: '<?php echo $roomInfo['Desc'];?>', // 分享描述
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
</script>
</head>

<body>
<div id="con">
	<div class="bg">
    	<img src="/images/bg.jpg">
    </div>
	<div class="room">
      <div class="xinxi">
        	<div class="person">
            	<img src="<?php echo $uInfo->user_logo;?>">
            	<div class="about">
            	    <p class="name">昵称：<?php echo $uInfo->nickname;?></p>
            	    <p class="numb">房间号：<?php echo $roomInfo['Room_id'];?></p>
            	    <p class="tip">提示：长按可复制房间号</p>
            	</div>
            </div>
               <div style="clear:both; height:0;"></div>
               <div class="org_box">
                    <span class="org_bot_cor"></span>
                    <?php echo $roomInfo['Desc'];?>   
               </div>
            </div>
        <img class="fj_bg" src="/images/fj_bg.png">
    </div>
    <div class="xc_pic">
    	<img src="/images/pic.png">
    </div>
    <!-- <div class="btn">
    	<a href="#">
        	<img src="/images/btn.png">
        </a>
    </div> -->
</div>
</body>
    <style type="text/css">
    *{ padding:0; margin:0 auto;}
	.bg{ width:100%; position:absolute; top:0; left:0; z-index:-9999}
	.bg img{ width:100%;}
	
	.room{ width:100%; position:relative;top: -10px;}
	.xc_pic{ width:100%; margin-top: -10px;}
	.room img,.xc_pic img{ width:100%;}
	.room .fj_bg{ position:relative; display:block}
	.room .xinxi{ position:absolute; z-index:111111; top: 48%; left: 17%; width: 66%;}
    .room .person{ width: 100%;}
	.room .person img{ width: 25%; padding: 3px; background: #ffffff; border: 2px solid #acacac; float: left; }
	
    .about{ float: left; margin-left: 2%; width: 65%}
    .about .name{ font-size: 1.1em;}
    .about .numb {letter-spacing: 1px; font-size: 1.1em; color: #fff; padding: 3px 0 3px 3px; width: 100%; background: #cb8c6e; border-radius: 12px; margin: 1px 0;}
    .about .tip{ font-size: 0.8em;}
	.btn{ text-align:center; margin-top: 10px;}
	.btn img{ width:60%;}
	.btn a img { border:none;}
        
        
    .org_box{font-size: .9em;padding-left: 2%;width: 95%;height:60px;padding-top: 2%;background:#fff; position:relative; border-radius: 8px;margin-top: 4%;}
    .org_bot_cor{width:0; height:0; font-size:0; border-width:12px; border-style:solid; border-color:transparent transparent #fff transparent; _border-color:transparent transparent #fff transparent;  overflow:hidden; position:absolute; left:20px; top:-22px;
   
}
    </style>
</html>
