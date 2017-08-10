<?php

/* @var $this \yii\web\View */
/* @var $content string */
use frontend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
use common\components\JSSDK;
$signPackage = JSSDK::getInstance( Yii::$app->params['AppId'], Yii::$app->params['AppSecret'] )->getSignPackage();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->context->title) ?></title>
    <link rel="stylesheet" href="/css/weui/weui.min.css">
    <?php $this->head() ?>
</head>
<body ontouchstart>
<?php $this->beginBody() ?>
<div class="wrap">
<?= $content ?>
</div>
<div class="weui-footer">
    <p class="weui-footer__text">Copyright © 2017 人人万州</p>
</div>
<script  type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script>
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
	// 在这里调用 API
});
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
