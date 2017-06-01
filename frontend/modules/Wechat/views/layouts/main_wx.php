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
        <article class="weui-article">
            <h1>我的邀请码：123123</h1>
        </article>
    </div>
</div>
<div class="weui-flex">
<?= $content ?>
</div>
</div>
<div class="weui-footer">
    <p class="weui-footer__text">Copyright © 2017 MG竞技</p>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
