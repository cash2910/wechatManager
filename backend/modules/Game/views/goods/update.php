<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameGoods */

$this->title = 'Update Mg Game Goods: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-game-goods-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
