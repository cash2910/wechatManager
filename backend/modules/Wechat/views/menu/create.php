<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WechatMenu */

$this->title = 'Create Wechat Menu';
$this->params['breadcrumbs'][] = ['label' => 'Wechat Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-menu-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
