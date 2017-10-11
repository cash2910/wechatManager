<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\MgGames */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mg-games-form">

    <p style="color:red;font-size:20px;">
        <?php  echo Yii::$app->getSession()->getFlash( 'msg'  ); ?>
    </p>
    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => '{label}<div class="col-sm-5">{input}</div><div class="col-sm-5">{error}</div>',
            'labelOptions' => ['class' => 'col-sm-2 control-label']
        ]
    ]); ?>

    <div class="form-group field-mggamegoods-title has-success">
        <label class="col-sm-2 control-label" for="mggamegoods-title">用户Id</label>
        <div class="col-sm-5">
            <input type="text" value="<?php echo ArrayHelper::getValue($model, 'uid') ?>"  class="form-control" name="uid" maxlength="20" aria-invalid="false">
        </div>
        <div class="col-sm-5">
            <div class="help-block"></div>
        </div>
    </div>
    
    <div class="form-group field-mggamegoods-title has-success">
        <label class="col-sm-2 control-label" for="mggamegoods-title">活跃用户数</label>
        <div class="col-sm-5">
            <input type="text" value="<?php echo ArrayHelper::getValue($model, 'score') ?>" class="form-control" name="score" maxlength="20" aria-invalid="false">
        </div>
        <div class="col-sm-5">
            <div class="help-block"></div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2">
        <?= Html::submitButton( isset( $model['id'] ) ? '新增' : '更新', ['class' => isset( $model['id'] ) ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
