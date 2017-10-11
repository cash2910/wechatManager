<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MgOrderList */

$this->title = '更新排行榜';
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mg-order-list-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
