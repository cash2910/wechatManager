<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WechatUserTag */

$this->title = 'Update Wechat User Tag: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wechat User Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wechat-user-tag-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
