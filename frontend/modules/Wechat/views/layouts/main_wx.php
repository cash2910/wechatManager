<?php

/* @var $this \yii\web\View */
/* @var $content string */
use frontend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
use common\components\JSSDK;
use yii\helpers\ArrayHelper;
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
    <p class="weui-footer__text">Copyright © 2017 <?php echo ArrayHelper::getValue(yii::$app->params, 'APP_NAME', '')?></p>
</div>
<script  type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>