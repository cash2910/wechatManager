<?php

/* @var $this \yii\web\View */
/* @var $content string */
use frontend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="/css/weui/weui.min.css">
    <?php $this->head() ?>
</head>
<body ontouchstart>
<?php $this->beginBody() ?>
<div class="wrap">
<div class="weui-flex">
    <div class="weui-flex__item">
        <div class="icon-box" style="padding:30px;">
            <img style="float:left;" src="http://pic.nen.com.cn/600/15/97/18/15971842_791759.jpg" width="80" height="80"/>
            <div style="float:left;  margin-left:15px;">
                <h4 >汉族教父</h4>
                <p class="icon-box__desc">加入时间：2017-05-24</p>
            </div>
        </div>
    </div>
</div>
<div class="weui-flex">
<?= $content ?>
</div>
</div>
<div class="weui-footer">
    <p class="weui-footer__text">Copyright © 2017 MG竞技</p>
</div>
<script>
$(function(){
	//alert(1);
})
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
