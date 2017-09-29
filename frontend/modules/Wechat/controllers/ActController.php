<?php
namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use yii;
use yii\web\Response;
use common\models\MgUsers;
use yii\helpers\ArrayHelper;


/**
 * Default controller for the `Wechat` module
 */
class ActController extends Controller
{
    public $layout = "main_wx";
    public $title ;
    //获取用户活跃度排行榜信息
    public function actionActRank(){
        $this->title = '排行榜';
        $data = yii::$app->redis->ZREVRANGE('ACT_ZSET_RANK', 0, 10,'WITHSCORES');
        $uMap = [];
        $users = [];
        if( !empty( $data ) ){
            $users = array_chunk($data, 2);
            foreach ( $users as $k => $info ){
                $temp = explode( "_", $info[0]);
                $uid = array_pop( $temp );
                $users[$k][2] = $uid;
                $uids[] = $uid;
            }
            $_users = MgUsers::findAll(['id'=>$uids]);
            foreach( $_users as $uObj ){
                $uMap[$uObj->id] = $uObj;
            }
        }
        return $this->render('act_rank',[
            'data' => $users,
            'uMap' => $uMap
        ]);
    }
}