<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgUserActlog */

$this->title = 'Create Mg User Actlog';
$this->params['breadcrumbs'][] = ['label' => 'Mg User Actlogs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-actlog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
