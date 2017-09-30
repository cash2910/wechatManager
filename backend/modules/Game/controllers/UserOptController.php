<?php

namespace backend\modules\Game\controllers;

use Yii;
use common\models\MgUserActlog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\MgUsers;

/**
 * UserOptController implements the CRUD actions for MgUserActlog model.
 */
class UserOptController extends Controller
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
     * Lists all MgUserActlog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = MgUserActlog::find();
        if(  ($user_id = Yii::$app->request->get('user_id', '') ) == true ){
            $query->andWhere(['user_id'=>$user_id]);
        }
        if(  ($opt_code = Yii::$app->request->get('opt', '') ) == true ){
            $query->andWhere(['opt'=>$opt_code]);
        }
        if(  ($from_date = Yii::$app->request->get('from_date', '') ) == true ){
            $query->andWhere(['>=','add_time',strtotime( $from_date )]);
        }
        if(  ($end_date = Yii::$app->request->get('end_date', '') ) == true ){
            $query->andWhere(['<=','add_time',strtotime( $end_date ) ]);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'add_time' => SORT_DESC,
                ]
            ]
        ]);
        
        $data = $dataProvider->getModels();
        $uids = array_unique( ArrayHelper::getColumn($data, 'user_id') );
        $userObjs = MgUsers::findAll( ['id'=>$uids] );
        $uMap = ArrayHelper::map($userObjs, 'id', 'nickname');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'uMap' => $uMap
        ]);
    }

    /**
     * Displays a single MgUserActlog model.
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
     * Creates a new MgUserActlog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MgUserActlog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MgUserActlog model.
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
     * Deletes an existing MgUserActlog model.
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
     * Finds the MgUserActlog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MgUserActlog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MgUserActlog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
