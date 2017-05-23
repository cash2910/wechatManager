<?php

namespace backend\modules\Wechat\controllers;

use yii;
use yii\web\Controller;
use yii\base\Module;
use yii\base\Event;

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
        $s = new myTest( "test" );
        $s->init();
        $eve = new Event();
        $eve->sender = ( $vvv = new Wechat() );
        $s->trigger("ttt",$eve)  ;
        var_dump($vvv);
    }
}

class myTest extends Module{
    
    public function init(){
        $this->on("ttt",[
            new Hello(),'say'   
        ]);
    }
    
}

class Hello{
    
    function say( $eve ){
        var_dump( $eve->sender );
        $eve->sender->setA("sdsadsadsa");
     //   return "hello world!";
    }
}

class Wechat{
    public $sss = "ffff";
    public function setA( $str ){
        $this->sss = $str;
    }
}
