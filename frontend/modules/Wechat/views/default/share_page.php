<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>MG竞技</title>
		<meta name="Keywords" content="MG竞技" />
		<meta name="Description" content="" />
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
		<script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
		<link rel="stylesheet" href="/files/style.css" />
	</head>
	<body>
		<h1>娄底放炮罚</h1>
<!-- 		<div class="download-app">
			<a href="https://itunes.apple.com/cn/app/id1164850097?mt=8"><img src="http://qp.cdn.supernanogame.com/images/web/appleld.png" /></a>
			<a href="http://qp.cdn.supernanogame.com/apk/fpf/fpf2.0.apk"><img src="http://qp.cdn.supernanogame.com/images/web/googleld.png" /></a>
		</div> -->
		<div class="qr">
			<p>专属二维码！</p>
			<img id="share_img" src="" />
		</div>
		
		<footer>MG竞技官方微信：MG竞技。</footer>
		<div id="tip">
			<p>如果没有自动跳转，可能是微信限制了第三方应用的跳转。</p>
			<p>1. 点击右上角的…</p>
			<p>2. 选择在浏览器中打开</p>
			<img src="http://qp.cdn.supernanogame.com/images/web/arrow.png" />
		</div>
	</body>
	<script type="text/javascript">
	
		var na = navigator.userAgent.toLowerCase(),
			tip = document.getElementById('tip');

		if (/micromessenger/.test(na)) {
			tip.style.display = 'block';
		}

		tip.onclick = function() {
			this.style.top = '-100%';
		};

 		function getQrCode( id, callback ){
			$.ajax({
				url:'/Wechat/default/get-qr-code?id='+id,
				success:function( data ){
					var data  = eval("("+data+")");
					callback( data );
				}
		    });
 	    }
 		getQrCode( '<?= $_GET['id'] ?>' , function( data ){
			$("#share_img").attr("src" ,data.pic_url );
 	 	});
	</script>
</html>
