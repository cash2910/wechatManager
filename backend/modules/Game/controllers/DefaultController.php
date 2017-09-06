<?php

namespace backend\modules\Game\controllers;

use yii\web\Controller;
use common\components\order\RebateBehavior;
use common\models\MgOrderList;
use common\service\users\UserService;
use common\models\MgUsers;
use yii\base\Object;

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
     /*    $balance = new RebateBehavior();
        $order = MgOrderList::findOne(['order_sn'=>'20170714125337101364']);
        $ret = $balance->doBalance( $order );
        var_dump($ret); */
        //return $this->render('index');
        // $uObj = MgUsers::findOne(['id'=>94]);
         //$ret = UserService::getInstance()->changeRatio( $uObj, 38 );
        // var_dump($ret);
      //  $proxys = UserService::getInstance()->getSubProxy( $uObj );
      //  $pTree = UserService::getInstance()->getProxyTree( $proxys, 94 );
      
      //  $be = new RebateBehavior();
      //  $be->doBalance( MgOrderList::findOne(['order_sn'=>''] ) );
    }
}
