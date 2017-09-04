<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WechatMessage */

$this->title = 'Update Wechat Message: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wechat-message-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
