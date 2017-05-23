<?php

namespace backend\modules\Wechat\controllers;

use Yii;
use common\models\WechatUserTag;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\service\weixin\WeChatService;
use yii\base\Exception;
use common\service\weixin\BusinessService;
use yii\helpers\ArrayHelper;

/**
 * TagController implements the CRUD actions for WechatUserTag model.
 */
class TagController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all WechatUserTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WechatUserTag::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WechatUserTag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new WechatUserTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WechatUserTag();
        if ($model->load(Yii::$app->request->post()) ) {
            //修改微信标签
            $ret = WeChatService::getIns()->createUserTag([
                'tag'=>[
                    'name'=> $model->tag_name
                ]
            ]);
            if( !ArrayHelper::getValue($ret, 'tag'))
                  throw new Exception('创建微信标签失败');
            $model->tag_id = $ret['tag']['id'];
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WechatUserTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
            //修改微信标签
            $ret = WeChatService::getIns()->updateUserTag([
                'tag'=>[
                    'id'=>$model->tag_id,
                    'name'=> $model->tag_name
                ]
            ]);
            if( 0 !== $ret['errcode'] )
                throw new Exception("修改微信标签失败: {$ret['errmsg']}");
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WechatUserTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $ret = WeChatService::getIns()->deleteUserTag([
            'tag'=>[
                'id'=>$model->tag_id
            ]
        ]);
        if( 0 !== $ret['errcode'] )
            throw new Exception("删除微信标签失败: {$ret['errmsg']}");
        $model->delete();
        return $this->redirect(['index']);
    }
    
    public function actionInit(){
        $ret = WeChatService::getIns()->getUserTag();
        if( !isset( $ret['tags'] ) ){
            throw new Exception('failed to get tags from wechat');
        }
        $tags = $ret['tags'];
        $ret = (new BusinessService())->initTag( $tags );
        return $this->redirect(['index']);
    }

    /**
     * Finds the WechatUserTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WechatUserTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WechatUserTag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
