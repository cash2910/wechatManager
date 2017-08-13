<?php

namespace backend\modules\Order\controllers;

use Yii;
use common\models\MgRebateList;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * RebateController implements the CRUD actions for MgRebateList model.
 */
class RebateController extends Controller
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
     * Lists all MgRebateList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query =  MgRebateList::find();
        
        if(  ($rebate_sn = Yii::$app->request->get('rebate_sn', '') ) == true ){
            $query->andWhere(['rebate_sn'=>$rebate_sn]);
        }
        if(  ($user_id = Yii::$app->request->get('user_id', '') ) == true ){
            $query->andWhere(['user_id'=>$user_id]);
        }
        if(  ($from_date = Yii::$app->request->get('from_date', '') ) == true ){
            $query->andWhere(['>=','add_time',strtotime( $from_date )]);
        }
        if(  ($end_date = Yii::$app->request->get('end_date', '') ) == true ){
            $query->andWhere(['<=','add_time',strtotime( $end_date ) ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' =>$query,
            'sort' => [
                'defaultOrder' => [
                    'add_time' => SORT_DESC,
                ]
            ]
        ]);
      //  var_dump($dataProvider);die();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MgRebateList model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MgRebateList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MgRebateList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rebate_sn]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MgRebateList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = yii::$app->request->get('id');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->rebate_sn]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MgRebateList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    
    

    /**
     * Finds the MgRebateList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MgRebateList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MgRebateList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
