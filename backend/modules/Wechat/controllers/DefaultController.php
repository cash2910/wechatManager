<?php

namespace backend\modules\Wechat\controllers;

use yii;
use yii\web\Controller;
use common\components\WeixinMenuConfig;
use common\service\weixin\WeChatResponseService;
use yii\helpers\ArrayHelper;
use common\service\users\UserService;


/**
 * Default controller for the `WeChat` module
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
    
    public function actionTest(){
        // $token = WeChatProxyService::getToken();
       // var_dump($token);
        /*
         $ret = WeChatService::getIns()->getAccessToken([
            'grant_type'=>'client_credential',
            'appid'=> yii::$app->params['AppId'] ,
            'secret'=>yii::$app->params['AppSecret']
        ]);
        var_dump($ret); 
        */
       // $ret = WeChatService::getIns()->getCallbackIp();
/*          $ret = WeChatService::getIns()->getMenu();
        print_r($ret); 
        //修改微信标签
          $arr = [
            'tag'=>[
                'name'=> 'vip2'
            ]
        ] ; */
/*       $ret = WeChatService::getIns()->updateUserTag([
                'tag'=>[
                    'id'=>106,
                    'name'=> 'vip11'
                ]
         ]);
          */
/*         $ret = WeChatService::getIns()->getUsers([
            
        ]); */
/*         $ret = WeChatService::getIns()->batchGetUsersInfo([
            'user_list'=>[
                ["openid"=> "oVM_Gt9udjlsp1U7t7sf0HPTERhk"],
                ["openid"=> "oVM_Gt4StRL6Cl2lh-34L5v_UruA"],
                ["openid"=> "oVM_Gt7OR4qXOMeSMN7DBL_eCMKo"]
            ]
        ]); */
        // var_dump($ret); 
        //生成临时二维码
/*         $ret = WeChatService::getIns()->createQrcode([
            'expire_seconds'=> 1400,
            'action_name' => 'QR_SCENE',
            'action_info' =>[
                'scene_id'=> str_pad( decbin(12), 32 , 0, STR_PAD_LEFT ),
            ]
        ]); */
      //  var_dump($ret);die();
/*         $id = 18; //'event_key'=>$entity->EventKey,
        $ret = UserService::getInstance()->createUser([
            'add_time'=> time(),
            'open_id' => '4546464646aaa',
            'ticket' => 'dsadsa'
        ],function( $model ) use ( $id ){
            $uInfo = UserService::getInstance()->getUserInfo([
                'id'=> $id
            ]);
            $rel = $uInfo->user_rels;
            $model->user_rels = $rel."-".$uInfo->id;
            $model->on( ActiveRecord::EVENT_AFTER_INSERT, function( $ent ) use ( $id ){
                $rel = new MgUserRel();
                $rel->user_id = $id;
                $rel->sub_user_id = $ent->sender->id;
                $rel->save();
            });
        }); */
        
/*         $conf  = WeixinMenuConfig::getConf( 'GET_SHARE_QRCODE' );
        if( empty($conf) ){
            die('...');
        }
        $ret = call_user_func_array([new $conf['class'], $conf['method']], [16]); */
        //echo  Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/default/share-page', 'id'=>555] );
        //$ret = UserService::getInstance()->checkExist( '321321' );
        $ret = UserService::getInstance()->modifyUser([
            'id'=> 11,
            'status'=> 2,
        ]);
        var_dump( $ret );
    }
}