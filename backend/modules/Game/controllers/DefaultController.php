<?php

namespace backend\modules\Game\controllers;

use yii\web\Controller;
use common\models\MgOrderList;
use common\components\order\SendProductBehavior;
use common\service\users\UserService;

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
/*       
        $be = new SendProductBehavior();
        $ret =  $be->sendPackage( MgOrderList::findOne(['order_sn'=>'2017071409015694219'] ) ); */
        $ret = UserService::getInstance()->modifyUser([
            'id'=> 121,
            'status'=> 2,
        ]);
        var_dump( $ret );
    }
}
