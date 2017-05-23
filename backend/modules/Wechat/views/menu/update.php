<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WechatMenu */

$this->title = 'Update Wechat Menu: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wechat-menu-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
