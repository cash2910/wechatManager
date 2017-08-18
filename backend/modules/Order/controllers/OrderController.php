<?php

namespace backend\modules\Order\controllers;

use Yii;
use common\models\MgOrderList;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\service\order\OrderService;
use yii\filters\AccessControl;
use common\helper\ExcelHelp;

/**
 * OrderController implements the CRUD actions for MgOrderList model.
 */
class OrderController extends Controller
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
     * Lists all MgOrderList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = MgOrderList::find();
        if(  ($order_sn = Yii::$app->request->get('order_sn', '') ) == true ){
            $query->andWhere(['order_sn'=>$order_sn]);
        }
        if(  ($nickname = Yii::$app->request->get('nick_name', '') ) == true ){
            $query->andWhere(['like','nick_name',$nickname]);
        }
        if(  ($user_id = Yii::$app->request->get('user_id', '') ) == true ){
            $query->andWhere(['user_id'=>$user_id]);
        }
        if(  ($p_status = Yii::$app->request->get('p_status', '') ) == true ){
            if( 1 == $p_status)
                 $query->andWhere(['<>','pay_sn',' ']);
            else 
               $query->andWhere(['pay_sn'=>' ']);
        }
        if(  ($p_status = Yii::$app->request->get('p_status', '') ) == true ){
            if( 1 == $p_status)
                $query->andWhere(['<>','pay_sn',' ']);
            else
              $query->andWhere(['pay_sn'=>' ']);
        }
        
        if(  ($from_date = Yii::$app->request->get('from_date', '') ) == true ){
            $query->andWhere(['>=','add_time',$from_date]);
        }
        
        if(  ($end_date = Yii::$app->request->get('end_date', '') ) == true ){
            $query->andWhere(['<=','add_time',$end_date]);
        }
        
        //导出
        if(Yii::$app->request->get('export')){
            
            $data = $query->all();
            $exObj = ExcelHelp::getPhpExcel();
            $exObj->setActiveSheetIndex(0);
            $i = 2;
            $objActSheet = $exObj->getActiveSheet();
            $objActSheet->setCellValue('B1', mb_convert_encoding( '订单号','utf-8' ) );
            $objActSheet->setCellValue('C1', mb_convert_encoding( '用户昵称','utf-8' ) );
            $objActSheet->setCellValue('D1', mb_convert_encoding( '用户id','utf-8' ) );
            $objActSheet->setCellValue('E1', mb_convert_encoding( '订单金额','utf-8' ) );
            $objActSheet->setCellValue('F1', mb_convert_encoding( '创建时间','utf-8' ) );
            $objActSheet->setCellValue('G1', mb_convert_encoding( '支付时间','utf-8' ) );
            $objActSheet->setCellValue('H1', mb_convert_encoding( '支付单号','utf-8' ) );
            foreach ( $data as $d ){
                $objActSheet->setCellValueExplicit('B' . $i, $d['order_sn'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('C' . $i, $d['nick_name'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('D' . $i, $d['user_id'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('E' . $i, $d['order_num'], \PHPExcel_Cell_DataType::TYPE_NUMERIC);
                $objActSheet->setCellValueExplicit('F' . $i, $d['add_time'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('G' . $i, $d['update_time'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $objActSheet->setCellValueExplicit('H' . $i, $d['pay_sn'], \PHPExcel_Cell_DataType::TYPE_STRING);
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
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'add_time' => SORT_DESC,            
                ]
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MgOrderList model.
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
     * Creates a new MgOrderList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MgOrderList();

        if ($model->load(Yii::$app->request->post()) ) {
            $data = Yii::$app->request->post('MgOrderList');
            //后台渠道
            $data['channel'] = MgOrderList::CS_CHANNEL;
            $ret = OrderService::getInstance()->createOrder( $data );
            $model = $ret['data'];
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MgOrderList model.
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
     * Deletes an existing MgOrderList model.
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
     * Finds the MgOrderList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MgOrderList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MgOrderList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
