<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '排行榜管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mg-game-goods-index">
    <p style="color:red;font-size:20px;">
        <?php  echo Yii::$app->getSession()->getFlash( 'msg'  ); ?>
    </p>
    <p>
        <?= Html::a('新增用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            ['label' => '用户名称','value' => function($data)  use ($uMap) {
                return $uMap[$data['id']]->nickname;
            }],
            ['label' => '活跃下级数','value' => function($data)  use ($uMap) {
                return $data['score'];
            }],
            [
                'header' => "查看／审核",
                'class' => 'yii\grid\ActionColumn',
                'template'=> '{update} {delete}',
                'headerOptions' => ['text-align' => 'center'],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                         return Html::a('修改', ['/Game/rank/update','id'=>$model['id']], ['class' => "btn btn-xs btn-info"]);
                    },
                    'delete' => function ($url, $model, $key) {
                         return Html::a('删除', ['/Game/rank/delete','id'=>$model['id']], ['class' => "btn btn-xs btn-danger"]);
                    }
                 ]
            ]
        ],
    ]); ?>
</div>
