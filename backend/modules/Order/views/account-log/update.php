<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgUserAccountLog */

$this->title = 'Update Mg User Account Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg User Account Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-user-account-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
