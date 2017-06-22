<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgOrderList */

$this->title = 'Update Mg Order List: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Order Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-order-list-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
