<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WechatCs */

$this->title = 'Update Wechat Cs: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Wechat Cs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wechat-cs-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
