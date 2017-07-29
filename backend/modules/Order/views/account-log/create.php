<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgUserAccountLog */

$this->title = 'Create Mg User Account Log';
$this->params['breadcrumbs'][] = ['label' => 'Mg User Account Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-log-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
