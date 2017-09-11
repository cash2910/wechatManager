<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgGameUseropt */

$this->title = 'Update Mg Game Useropt: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Useropts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-game-useropt-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
