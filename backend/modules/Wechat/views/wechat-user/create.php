<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WechatUsers */

$this->title = 'Create Wechat Users';
$this->params['breadcrumbs'][] = ['label' => 'Wechat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-users-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
