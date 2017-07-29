<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgGameGoods */

$this->title = 'Create Mg Game Goods';
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-goods-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>