<?php

namespace backend\modules\Game\controllers;

use Yii;
use common\models\MgGameUseropt;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GameOptController implements the CRUD actions for MgGameUseropt model.
 */
class GameOptController extends Controller
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
     * Lists all MgGameUseropt models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $query =  MgGameUseropt::find();
        
        if(  ($ip = Yii::$app->request->get('ip', '') ) == true ){
            $query->andWhere(['ip'=>$ip]);
        }
        if(  ($union_id = Yii::$app->request->get('union_id', '') ) == true ){
            $query->andWhere(['union_id'=>$union_id]);
        }
        if(  ($from_date = Yii::$app->request->get('from_date', '') ) == true ){
            $query->andWhere(['>=','add_time',strtotime( $from_date )]);
        }
        if(  ($end_date = Yii::$app->request->get('end_date', '') ) == true ){
            $query->andWhere(['<=','add_time',strtotime( $end_date ) ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' =>$query ,
            'sort' => [
                'defaultOrder' => [
                    'add_time' => SORT_DESC,
                ]
            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MgGameUseropt model.
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
     * Creates a new MgGameUseropt model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MgGameUseropt();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MgGameUseropt model.
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
     * Deletes an existing MgGameUseropt model.
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
     * Finds the MgGameUseropt model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MgGameUseropt the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MgGameUseropt::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
