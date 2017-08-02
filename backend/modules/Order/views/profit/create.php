<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgUserAccount */

$this->title = 'Create Mg User Account';
$this->params['breadcrumbs'][] = ['label' => 'Mg User Accounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-user-account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
