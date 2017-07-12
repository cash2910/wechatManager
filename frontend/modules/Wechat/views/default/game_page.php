<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $gInfo->title; ?></title>
    <link rel="stylesheet" href="/css/game_css.css">
    <script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript">
    	/*alert(1);
		var na = window.navigator.userAgent.toLowerCase(),
			tip = document.getElementById('tip');

		if ((ua.match(/MicroMessenger/i) == 'micromessenger')) {
		//if (!/micromessenger/.test(na)) {
			tip.style.display = 'block';
		}

		tip.onclick = function() {
			this.style.top = '-100%';
		};
	*/
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
</script>
</head>

<body>
<div id="contents">
	<div class="banner"><img src="/images/banner.png"></div>
  <div class="icon_ma">
    	<div class="icon">
        	<a class="android" href="http://xxx/xxx.apk" ><img src="/images/android_icon.png"></a>
            <a class="iphone" href="http://itunes.apple.com/us/app/pei-yi/id1126325671?l=zh&ls=1&mt=8" id="JdownApp" ><img src="/images/iphone_icon.png"></a>
      </div>
        <div class="erweima">
        	<img src="/images/erweima.png">
        </div>
    </div>
    <div id="tip">
			<p>如果没有自动跳转，可能是微信限制了第三方应用的跳转。</p>
			<p>1. 点击右上角的…</p>
			<p>2. 选择在浏览器中打开</p>
			<img src="/images/arrow.png">
		</div>
</div>
</body>

</html>
