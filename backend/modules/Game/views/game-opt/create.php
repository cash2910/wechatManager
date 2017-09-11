<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgGameUseropt */

$this->title = 'Create Mg Game Useropt';
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Useropts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-useropt-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
