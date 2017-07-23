<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use backend\widgets\SideNav;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->params['company_name'],
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/Game/game/index']],
        ['label' => '游戏管理', 'url' => ['/Game/game/index']],
        ['label' => '微信管理', 'url' => ['/Wechat/wechat-user']],
        ['label' => '订单管理', 'url' => ['/Order/order']],
       // ['label' => '推广员管理', 'url' => ['/Wechat/menu']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                '退出 (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="row" style="padding: 70px 15px 20px; margin-left:0px;margin-right:0px;">
        <div class="col-md-2">
            <?php
                $items = [];
                if( method_exists( $this->context->module, 'getMenu' ) )
                    $items = $this->context->module->getMenu( yii::$app->request->pathInfo );
                echo SideNav::widget( $items ) 
            ?>
        </div>
        <div class="col-md-9">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
   </div>  
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy;<?= Yii::$app->params['company_name'] ?><?= date('Y') ?></p>
        <p class="pull-right"><?= 'powered by '.Yii::$app->params['company_name'] ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
