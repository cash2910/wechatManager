<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MgGameGift */

$this->title = 'Create Mg Game Gift';
$this->params['breadcrumbs'][] = ['label' => 'Mg Game Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-gift-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
