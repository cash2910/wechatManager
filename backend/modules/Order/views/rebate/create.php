<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgRebateList */

$this->title = 'Create Mg Rebate List';
$this->params['breadcrumbs'][] = ['label' => 'Mg Rebate Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-rebate-list-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
