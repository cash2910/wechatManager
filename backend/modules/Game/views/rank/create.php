<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgGames */

$this->title = '新增用户';
$this->params['breadcrumbs'][] = ['label' => '新增用户', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-games-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
