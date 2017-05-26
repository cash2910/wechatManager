<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgUsers */

$this->title = 'Update Mg Users: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-users-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
