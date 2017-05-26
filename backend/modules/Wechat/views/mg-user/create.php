<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgUsers */

$this->title = 'Create Mg Users';
$this->params['breadcrumbs'][] = ['label' => 'Mg Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-users-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
