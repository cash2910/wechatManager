<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WechatUsers */

$this->title = 'Update Wechat Users: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wechat-users-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
