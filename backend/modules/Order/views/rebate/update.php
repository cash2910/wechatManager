<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgRebateList */

$this->title = 'Update Mg Rebate List: ' . $model->rebate_sn;
$this->params['breadcrumbs'][] = ['label' => 'Mg Rebate Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rebate_sn, 'url' => ['view', 'id' => $model->rebate_sn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-rebate-list-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
