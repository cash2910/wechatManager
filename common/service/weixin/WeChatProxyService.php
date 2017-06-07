<?php
namespace common\service\weixin;

use yii;
use common\components\WeixinConfig;
use yii\base\Exception;
use common\utils\Curl;
use yii\helpers\ArrayHelper;
class WeChatProxyService{
    
    public function  __call( $method, $params ){
        $conf = WeixinConfig::getConf( $method );
        $arg = isset( $params[0] ) ? $params[0] : [];
        if( empty( $conf ) )
            $this->NoConf( $method, $arg );
        return $this->process( $conf, $arg );
    }
    
    
    protected function process( $conf, $params ){
     
        $finalUrl = $this->buildUrl( $conf, $params );
        if( !$finalUrl )
            throw new Exception("invalid wechat url...");
        $curl = new Curl();
        $curl->setOptions([ CURLOPT_SSL_VERIFYPEER=> false,  CURLOPT_SSL_VERIFYHOST => 0 ]);
        if( ArrayHelper::getValue($conf, 'isPost', false) ){
            $res =  $curl->setOption(CURLOPT_POSTFIELDS, json_encode($params, JSON_UNESCAPED_UNICODE) )->post( $finalUrl );
        }else{
            $res = $curl->get( $finalUrl );
        }
        return json_decode( $res, true );
    }
    
    protected function buildUrl( $conf, $params ){
        $url = ArrayHelper::getValue($conf, 'url');
        //获取token 与生成二维码不需要access_token
        if( ArrayHelper::getValue($conf, 'need_token', true)  ){
             $params['access_token'] =self::getToken( true );
        }
        /**
         * @todo 修改为字符串替换参数
         */
        if( !empty( $params )  )
            $url .= "?".http_build_query( $params );
        return $url;
    }
    
    /**
     * 获取token并保存
     * @force 是否强制重新获取token
     */
    static public function getToken( $force = false ){
         $token = '';
         if( !$force )
             $token = yii::$app->redis->get( WeixinConfig::TOKEN_KEY );
         $ret = yii::$app->redis->ttl(WeixinConfig::TOKEN_KEY);
         if( empty($token) ){
             $res = WeChatService::getIns()->getAccessToken([
                'grant_type'=>'client_credential',
                'appid'=> yii::$app->params['AppId'] ,
                'secret'=>yii::$app->params['AppSecret']
             ]);
             $token = $res['access_token'];
             yii::$app->redis->set( WeixinConfig::TOKEN_KEY, $token, 'EX', 7000 );
         }
         return $token;
    }
    
    protected function NoConf( $method, $params){
        throw new Exception("Can't not find $method's config .");
    }
        
}

?>