
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $gInfo->title ?></title>
		<meta name="Keywords" content="二百胡,娄底放炮罚,湘乡告胡子，跑胡子" />
		<meta name="Description" content="" />
		<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=0"/>
		<link rel="stylesheet" href="/files/style.css" />
	</head>
	<body>
		<h1><?php echo $gInfo->title ?></h1>
		<div class="download-app">
			<a href="https://itunes.apple.com/cn/app/id1164850097?mt=8"><img src="http://qp.cdn.supernanogame.com/images/web/appleld.png" /></a>
			<a href="http://qp.cdn.supernanogame.com/apk/fpf/fpf2.0.apk"><img src="http://qp.cdn.supernanogame.com/images/web/googleld.png" /></a>
		</div>
		<div class="qr">
			<p>请关注官方公众号！</p>
			<img src="http://qp.cdn.supernanogame.com/images/web/qr.jpg" />
		</div>
		
		<footer>湖南棋牌官方微信：hnqp11。京ICP证16056757号</footer>
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
		//if (!/micromessenger/.test(na)) {
			tip.style.display = 'block';
		}

		tip.onclick = function() {
			this.style.top = '-100%';
		};
	</script>
</html>
