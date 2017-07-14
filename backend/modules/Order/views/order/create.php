<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgOrderList */

$this->title = 'Create Mg Order List';
$this->params['breadcrumbs'][] = ['label' => 'Mg Order Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-order-list-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
