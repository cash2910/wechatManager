<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\models\MgUserActlog;
use common\models\MgOrderList;
use common\service\order\OrderService;
use common\models\MgUsers;
use common\service\game\StatisticsService;

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
/*               $super =  UserService::getInstance()->getUserInfo(['open_id'=>'321321']);
              $uObj2 =  UserService::getInstance()->getUserInfo(['open_id'=>'o9Unv0a0sL-H8lREpQ86O5WodVyg']);
              $ret = UserService::getInstance()->bindRel( $super , $uObj2 );
              var_dump( $ret ); */
/*       $order = MgOrderList::findOne(['order_sn'=>'2017071512191694769']);
      OrderService::getInstance()->payOrder( $order, [
          'total_fee'=> 10000,
          'transaction_id' =>'DSADSDS'
      ]); */
     /*  $date = [
               'from'=>'2017-09-01',
               'to' => '2017-11-08'
            ];
        $logs = MgUserActlog::find()->where(['open_id1'=>'dsadsa'])->andWhere(['between', 'add_time', strtotime($date['from']),  strtotime($date['to']) ])->one();
         */
        $uObj = MgUsers::findOne(['id'=>304]);
        $ret = StatisticsService::getInstance()->checkIsActUser( $uObj ,[
            'from'=>'2017-09-01',
            'to' => '2017-11-08'
        ]);
        var_dump( $ret );
    }
    
    
}
