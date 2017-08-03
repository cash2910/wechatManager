<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\service\weixin\WeChatService;
use common\service\order\OrderService;
use common\models\MgOrderList;
use common\components\order\BalanceBehavior;
use common\service\users\UserService;
use common\models\MgUsers;

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
          $super =  UserService::getInstance()->getUserInfo(['open_id'=>'o9Unv0ZyVUaNOQ-HjnXO6mpASKpc']);
          $uObj2 =  UserService::getInstance()->getUserInfo(['open_id'=>'o9Unv0a0sL-H8lREpQ86O5WodVyg']);
          $ret = UserService::getInstance()->bindRel( $super , $uObj2 );
          var_dump( $ret );
    }
    
    
}
