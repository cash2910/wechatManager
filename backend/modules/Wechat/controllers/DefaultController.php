<?php

namespace backend\modules\Wechat\controllers;

use yii;
use yii\web\Controller;
use common\components\WeixinMenuConfig;
use common\service\weixin\WeChatResponseService;
use yii\helpers\ArrayHelper;


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
        $xmlObj = new ProxyXml();
        $ret = $xmlObj->buildXml([
             'FromUserName'=>'dsadsadsa',
             'ToUserName'=>'aaaaaa',
             'MsgType'=>'news',
             'ArticleCount'=>1,
             'Articles'=>[
                 ['item'=>[
                     'Title'=>'王者农药',
                     'Description'=>'王者农药 就是干',
                     'PicUrl'=> 'http://imgtg.37wan.com/u/2017/0508/081112549ctt7.jpg',
                     'Url' =>'https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=3365950462,3553557768&fm=58'
                 ]],
                 ['item'=>[
                     'Title'=>'王者农药1',
                     'Description'=>'王者农药 就是干',
                     'PicUrl'=> 'http://imgtg.37wan.com/u/2017/0502/02111015pXtoF.jpg',
                     'Url' =>'https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=3365950462,3553557768&fm=58'
                 ]],
                 ['item'=>[
                     'Title'=>'王者农药2',
                     'Description'=>'王者农药 就是干',
                     'PicUrl'=> 'http://imgtg.37wan.com/u/2017/0502/02144626JFkQz.jpg',
                     'Url' =>'https://ss1.baidu.com/6ONXsjip0QIZ8tyhnq/it/u=3365950462,3553557768&fm=58'
                 ]]
             ]
         ]);
        header("Content-type: text/xml");
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo $ret ;
    }
}



class ProxyXml{
    private $xml = null;
    private $response = ' ';
    //需要添加<![CDATA[url]]> 元素列表
    const WRAP_LIST = ['ToUserName','FromUserName','MsgType','Content','MediaId',
        'Title','Description','MusicUrl','HQMusicUrl','ThumbMediaId','PicUrl','Url'];
    function __construct( $xmlObj = null ){
        $this->xml = $xmlObj;
    }
    function __get( $attr ){
        return isset( $this->xml->$attr ) ? trim( $this->xml->$attr ) : "";
    }

    function setResp( $data ){
        $default = [
            'CreateTime'=>ArrayHelper::getValue($_SERVER, 'REQUEST_TIME', time()),
            //    'FromUserName'=> 'glory_jzx'//Yii::$app->params['AppId']
        ];
        $this->response = $this->buildXml( array_merge($default,$data) );
    }

    function getResp() {
        return $this->response;
    }

    function buildXml( $data, $wrap= 'xml' ){
        $str = "<{$wrap}>";
        if( is_array( $data ) )
            if( !ArrayHelper::isIndexed( $data,true ) ){
                foreach( $data as $k=>$v ){
                    $str .= $this->buildXml( $v, $k  );
                }
            }else{
                foreach( $data as $v ){
                    foreach( $v as $k1=>$v1 )
                        $str .= $this->buildXml( $v1, $k1 );
                }
            }
        else
            $str .= $this->wrap($wrap, $data );
        $str .= "</{$wrap}>";
        return $str;
    }
     

    function wrap( $k, $v ){
        $formate = '%s';
        if( in_array( $k, ProxyXml::WRAP_LIST) )
            $formate = '<![CDATA[%s]]>';
        return sprintf( $formate,  $v );
    }
}


