<?php
namespace common\components\wxtransfer;

use yii;
use common\models\TransferEntity;

/**
 * 微信交易方法
 * 向制定用户打款
 * @author zaixing.jiang
 *
 */
require_once yii::$app->basePath.'/../common/components/wxpay/WxPayConfig.php';
class WeixinTransfer{

    private $data = null;
    const TRANSFER_URL = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
    
    public function setData( TransferEntity $entity ) {
        if( !$entity->validate() ){
            throw new \Exception( 'error:'.json_encode( $entity->getErrors() ) );
        }
        $this->data = $entity;
        $this->getBaseInfo();
        $this->getNonceStr();
        $this->getSign();
        return $this;
    }
    
    private function getBaseInfo(){
        
        if( !empty( $this->data->mch_appid ) && !empty( $this->data->mchid )  )
            return false;
        $this->data->mch_appid = \WxPayConfig::APPID;
        $this->data->mchid = \WxPayConfig::MCHID;
    }
    
    private function getSign(){
        if( !empty( $this->data->sign ) )
            return false;
        $arr = $this->data->getAttributes();
        ksort( $arr );
        $arr = array_filter( $arr );
        $str = http_build_query( $arr )."&key=".\WxPayConfig::KEY;
        $this->data->sign = strtoupper( Md5($str) );
    }
    
    private function getXML(){
        $data = $this->data->getAttributes();
        $xml = "<xml>";
        foreach ( $data  as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    
    private function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        $this->data->nonce_str = $str;
    }
    
    public function doTransFer(){
        
        $vars = $this->getXML();
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT, 1);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        curl_setopt($ch,CURLOPT_URL, self::TRANSFER_URL );
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        
        //以下两种方式需选择一种
        curl_setopt($ch,CURLOPT_SSLCERT, yii::$app->params['CERT_PATH'].'/apiclient_cert.pem');
        curl_setopt($ch,CURLOPT_SSLKEY, yii::$app->params['CERT_PATH'].'/apiclient_key.pem');
        curl_setopt($ch,CURLOPT_CAINFO, yii::$app->params['CERT_PATH'].'rootca.pem');
        
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $vars );
        $data = curl_exec($ch);
        if($data){
            curl_close($ch);
            var_dump( $data );
            return $data;
        }
        else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }
    
}



?>