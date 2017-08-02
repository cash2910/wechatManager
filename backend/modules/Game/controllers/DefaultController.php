<?php

namespace backend\modules\Game\controllers;

use yii\web\Controller;
use common\components\order\BalanceBehavior;
use common\models\MgOrderList;

/**
 * Default controller for the `Game` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //2017072316553499150
        $balance = new BalanceBehavior();
        $order = MgOrderList::findOne(['order_sn'=>'2017072316553499150']);
        $ret = $balance->doBalance( $order );
        var_dump($ret);
        //return $this->render('index');
    }
}
