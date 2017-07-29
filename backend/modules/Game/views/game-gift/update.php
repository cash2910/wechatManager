<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameGift */

$this->title = 'Update Mg Game Gift: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-game-gift-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
