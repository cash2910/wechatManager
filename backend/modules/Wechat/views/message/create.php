<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WechatMessage */

$this->title = 'Create Wechat Message';
$this->params['breadcrumbs'][] = ['label' => 'Wechat Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-message-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
