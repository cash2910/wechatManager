<?php

namespace backend\modules\Game\controllers;

use Yii;
use common\models\MgGameUseropt;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\MgUsers;
use common\helper\ExcelHelp;

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
        
        if(  ($opt_code = Yii::$app->request->get('opt_code', '') ) == true ){
            $query->andWhere(['opt_code'=>$opt_code]);
        }
        if(  ($from_date = Yii::$app->request->get('from_date', '') ) == true ){
            $query->andWhere(['>=','add_time',strtotime( $from_date )]);
        }
        if(  ($end_date = Yii::$app->request->get('end_date', '') ) == true ){
            $query->andWhere(['<=','add_time',strtotime( $end_date ) ]);
        }
        
        //导出
        if(Yii::$app->request->get('export')){
        
            $data = $query->all();
            $exObj = ExcelHelp::getPhpExcel();
            $exObj->setActiveSheetIndex(0);
            $i = 2;
            $objActSheet = $exObj->getActiveSheet();
            $objActSheet->setCellValue('B1', mb_convert_encoding( 'union_id','utf-8' ) );
            $objActSheet->setCellValue('C1', mb_convert_encoding( '操作类型','utf-8' ) );
            $objActSheet->setCellValue('D1', mb_convert_encoding( '详细信息','utf-8' ) );
            $objActSheet->setCellValue('E1', mb_convert_encoding( '添加时间','utf-8' ) );
            foreach ( $data as $d ){
                $objActSheet->setCellValueExplicit('B' . $i, $d['union_id'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('C' . $i, $d['opt_code'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('D' . $i, $d['data'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('E' . $i, date( 'Y-m-d H:i:s',$d['add_time'] ), \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $i++;
            }
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . date("Y-m-d H:i", time()) . '订单.xls"');
            header('Cache-Control: max-age=0');
            $objWriter = ExcelHelp::getWriterInstance( $exObj, 'Excel5');
            $objWriter->save('php://output');
            exit();
            //return  '';
        }
        
        
        $dataProvider = new ActiveDataProvider([
            'query' =>$query ,
            'sort' => [
                'defaultOrder' => [
                    'add_time' => SORT_DESC,
                ]
            ]
        ]);
        
        
        $data = $dataProvider->getModels();
        $union_ids = array_unique( ArrayHelper::getColumn($data, 'union_id') );
        $userObjs = MgUsers::findAll( ['union_id'=>$union_ids] );
        $uMap = ArrayHelper::map($userObjs, 'union_id', 'nickname');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'uMap' => $uMap
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
