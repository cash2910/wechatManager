<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use common\service\weixin\WeChatResponseService;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use yii;

/**
 * Default controller for the `Wechat` module
 */
class WechatResponseController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * http://client.me.com/Wechat/wechat-response
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(){
        
        //检测sign
        //响应用户请求
        try{
	    $response = ( new WeChatResponseService("wechat") )->run( ArrayHelper::getValue( $GLOBALS, "HTTP_RAW_POST_DATA", "" ) );
            echo $response->getResp();
        }catch ( Exception $e){
            yii::error($e->getMessage(),"errors");
        }
        //logmsg
        
    }
    
}
