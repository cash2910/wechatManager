<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\service\weixin\WeChatService;
use common\service\order\OrderService;
use common\models\MgOrderList;
use common\components\order\BalanceBehavior;

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
        $ret = WeChatService::getIns()->sendCsMsg([
            'touser'=> 'o9Unv0a0sL-H8lREpQ86O5WodVyg',
            'msgtype'=>'text',
            'text'=>[
                'content'=> "恭喜您成功获得充值返利100 元！~"
             ]
        ]);
        var_dump( $ret );
    }
    
    
}
