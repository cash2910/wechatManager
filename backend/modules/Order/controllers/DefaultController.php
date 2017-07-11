<?php

namespace backend\modules\Order\controllers;

use yii;
use yii\web\Controller;
use common\models\MgRebateList;
use common\service\order\RebateService;
use yii\base\Exception;

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
    
}
