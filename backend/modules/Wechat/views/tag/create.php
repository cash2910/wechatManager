<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WechatUserTag */

$this->title = 'Create Wechat User Tag';
$this->params['breadcrumbs'][] = ['label' => 'Wechat User Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wechat-user-tag-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
