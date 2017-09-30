<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgUserActlog */

$this->title = 'Update Mg User Actlog: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg User Actlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-user-actlog-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
