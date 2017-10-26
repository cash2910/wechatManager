<?php

namespace backend\modules\Wechat\controllers;

use Yii;
use common\models\MgUsers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MgUserController implements the CRUD actions for MgUsers model.
 */
class MgUserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MgUsers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query =  MgUsers::find();
        if(  ($user_id = Yii::$app->request->get('user_id', '') ) == true ){
            $query->andWhere(['id'=>$user_id]);
        }
        if(  ($nickname = Yii::$app->request->get('nickname', '') ) == true ){
            $query->andWhere(['like','nickname',$nickname]);
        }
        if(  ($status = Yii::$app->request->get('status', '') ) == true ){
            $query->andWhere(['status'=>$status]);
        }
        if(  ($open_id = Yii::$app->request->get('open_id', '') ) == true ){
            $query->andWhere(['open_id'=>$open_id]);
        }
        if(  ($union_id = Yii::$app->request->get('union_id', '') ) == true ){
            $query->andWhere(['union_id'=>$union_id]);
        }
        
        if(  ($user_role = Yii::$app->request->get('user_role', '') ) !== '' ){
            $query->andWhere(['user_role'=>$user_role]);
        }

        if(  ($rels = Yii::$app->request->get('fri', '') ) == true ){
            $query->andWhere(['like','user_rels', "{$rels}%", false ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' =>$query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MgUsers model.
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
     * Creates a new MgUsers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MgUsers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MgUsers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MgUsers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MgUsers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MgUsers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MgUsers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
