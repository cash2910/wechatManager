<?php

namespace backend\modules\Game\controllers;

use Yii;
use common\models\MgGameUseropt;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\MgUsers;
use yii\data\ArrayDataProvider;

/**
 * GameOptController implements the CRUD actions for MgGameUseropt model.
 */
class RankController extends Controller
{
    const RANK_ZSET_KEY = 'ACT_ZSET_RANK';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * Lists all MgGameUseropt models.
     * @return mixed
     */
    public function actionIndex()
    {
        //yii::$app->redis->zincrby( self::RANK_ZSET_KEY , 22, "user_act_users_100"  ); die();
        $users = [];
        $uMap = [];
        $data = yii::$app->redis->ZREVRANGE('ACT_ZSET_RANK', 0, -1,'WITHSCORES');
        if( !empty( $data ) ){
            $_users = array_chunk($data, 2);
            foreach ( $_users as $k => $info ){
                $temp = explode( "_", $info[0]);
                $uid = array_pop( $temp );
                $_arr['id'] = $uid;
                $_arr['score'] = $info[1];
                $uids[] = $uid;
                $users[] = $_arr;
            }
            $uObjs = MgUsers::findAll(['id'=>$uids]);
            foreach( $uObjs as $uObj ){
                $uMap[$uObj->id] = $uObj;
            }
        }
        $data = new ArrayDataProvider([
            'allModels' => $users,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'score'],
            ],
        ]);
        
        return $this->render('index',[
            'dataProvider' => $data,
            'uMap' => $uMap
        ]);
    }

    /**
     * Creates a new MgGameUseropt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if ( Yii::$app->request->post('uid') && Yii::$app->request->post('score') ) {
            $uid = (int)Yii::$app->request->post('uid');
            $uObj = MgUsers::findOne(['id'=>$uid]);
            if( !$uObj ){
                Yii::$app->getSession()->setFlash( 'msg' , '用户信息不存在' );
                return $this->render('create', [
                    'model' => [],
                ]);
            }
            yii::$app->redis->zincrby( self::RANK_ZSET_KEY , (int)Yii::$app->request->post('score'), "user_act_users_{$uid}"  );
            return $this->redirect(['index']);
        } else {
            //Yii::$app->getSession()->setFlash( 'msg' , $ret['msg'] );
            return $this->render('create', [
                'model' => [],
            ]);
        }
    }

    /**
     * Updates an existing MgGameUseropt model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = yii::$app->request->get('id');
        $key = "user_act_users_{$id}";
        $score = (int)yii::$app->redis->ZSCORE( 'ACT_ZSET_RANK', $key);       
        if( empty($score) ){
            Yii::$app->getSession()->setFlash( 'msg' , '用户信息不存在' );
            return $this->redirect(['index']);
        }
        if (  Yii::$app->request->post('score') ) {
            yii::$app->redis->zadd( self::RANK_ZSET_KEY , (int)Yii::$app->request->post('score'),  $key  );
            return $this->redirect(['update?id='.$id]);
        } else {
            return $this->render('update', [
                'model' => [
                    'uid'=>$id,
                    'score'=>$score
                ],
            ]);
        }
    }

    /**
     * Deletes an existing MgGameUseropt model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        yii::$app->redis->zrem( self::RANK_ZSET_KEY ,  "user_act_users_{$id}" );
        return $this->redirect(['index']);
    }

}
