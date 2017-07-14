<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WechatCs */

$this->title = 'Create Wechat Cs';
$this->params['breadcrumbs'][] = ['label' => 'Wechat Cs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-cs-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
