<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgGames */

$this->title = 'Create Mg Games';
$this->params['breadcrumbs'][] = ['label' => 'Mg Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-games-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
