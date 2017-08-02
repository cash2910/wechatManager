<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgUserAccount */

$this->title = 'Update Mg User Account: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mg User Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-user-account-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
