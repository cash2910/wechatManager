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
        
        echo $h;
    }
    
    
}
