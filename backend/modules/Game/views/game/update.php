<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgGames */

$this->title = 'Update Mg Games: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Mg Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-games-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
