<?php

namespace backend\modules\Order\controllers;

use yii;
use yii\web\Controller;
use common\models\MgRebateList;
use common\service\order\RebateService;
use yii\base\Exception;
use common\models\MgOrderList;
use common\components\CommonResponse;

/**
 * Default controller for the `Order` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 审核用户提现
     * 1、校验是否已经审核
     * 2、生成提现流水
     * @throws NotFoundHttpException
     */
    public function actionApplyRebate(){
        
        $id = yii::$app->request->get('id');
        if (!( $model = MgRebateList::findOne([ 'id'=>$id ]) ) ) {
            throw new Exception('信息不存在');
        }
        //$model->rebate_num = 1;
        $ret = RebateService::getInstance()->applyRebate( $model );
        Yii::$app->getSession()->setFlash( 'msg' , $ret['msg'] );
        $this->redirect(['/Order/rebate']);
    }
    
    /**
     * 驳回提现请求
     * @throws NotFoundHttpException
     */
    public function actionRejectRebate(){
    
        $id = yii::$app->request->get('id');
        if (!( $model = MgRebateList::findOne($id) ) ) {
            throw new NotFoundHttpException('信息不存在');
        }

    }
    
    /**
     * 获取最近7天充值信息
     */
    public function actionGetCharge(){
    
        $ret = ['isOk'=>1,'msg'=>'获取成功','data'=>[]];
        try{
            $f = $from = strtotime("-7 day");
            $to = time();
            $_date = [];
            while ( $from < $to ) {
                $_d = date('Y-m-d', $from );
                $_date[$_d] = 0;
                $from += 86400;
            }
            $oList = MgOrderList::find()->andWhere(['<>','pay_sn',' '])->andWhere(['between', 'add_time', date('Y-m-d', $f ),  date('Y-m-d',$to )])->all();
            foreach ($oList as $order ){
                list( $_d, $t) = explode( " ", $order->add_time );
                $_date[$_d] += $order->order_num;
            }
            $ret['data']['series'] = array_keys( $_date );
            $ret['data']['sum'] = array_values( $_date );;
        }catch (\Exception $e){
            $ret['isOk'] = 0;
            $ret['msg'] = $e->getMessage();
        }
        CommonResponse::end( $ret );
    }
    
}
