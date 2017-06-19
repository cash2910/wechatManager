<?php
namespace common\components;
use yii;
use yii\authclient\OAuth2;
use yii\authclient\OAuthToken;

class WeixinAuthClient extends OAuth2{
    
    public $authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize';
    public $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    public $getUserUrl = 'https://api.weixin.qq.com/sns/userinfo';
    
    public $scope= 'SCOPE';  //获取用户的union_id
    
    public function buildAuthUrl(array $params = [])
    {
        $defaultParams = [
            'appid' => yii::$app->params['AppId'],
            'response_type' => 'code',
            'redirect_uri' => $this->getReturnUrl(),
            //'xoauth_displayname' => Yii::$app->name,
        ];
        if (!empty($this->scope)) {
            $defaultParams['scope'] = $this->scope;
        }
    
        return $this->composeUrl($this->authUrl, array_merge($defaultParams, $params))."#wechat_redirect";
    }
    
    public function fetchAccessToken( $code, array $params = [] ) {

        $defaultParams = [
            'appid' => yii::$app->params['AppId'],
            'secret' =>  yii::$app->params['AppSecret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
         //   'redirect_uri' => $this->getReturnUrl(),
        ];
        
        $request = $this->createRequest()
        ->setMethod('POST')
        ->setUrl($this->tokenUrl)
        ->setData(array_merge($defaultParams, $params));
        
        $response = $this->sendRequest($request);
        
        if( !isset( $response['access_token'] ) ){
            //log...
        }
        $token = $this->createToken(['params' => [
            'access_token'=>$response['access_token'],
            'open_id' => $response['openid'],
         //   'union_id' => $response['unionid'],
            'expir'=> 7000
        ]]);
        $this->setAccessToken($token);
        
        return $token;
        
    }
    
    
    public function refreshAccessToken( OAuthToken $token )
    {
        $url = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat'] );
        $wbServ =  $this->setReturnUrl( $url );
        Yii::$app->getResponse()->redirect($url);
    }
    
    
    public function getUserInfo( $token, $open_id ){
        
        $url = $this->getUserUrl."?".http_build_query([
            ''
        ]);

        $request = $this->createRequest()
        ->setMethod('GET')
        ->setUrl( $this->tokenUrl )
        ->setData(array_merge($defaultParams, $params));
        
        $response = $this->sendRequest($request);
        
        if( isset( $response['errcode'] ) ){
            //log...
            
        }
        $token = $this->createToken(['params' => [
            'access_token'=>$response['access_token'],
            'open_id' => $response['openid'],
            'union_id' => $response['union_id'],
            'expir'=> 7000
        ]]);
        
    }
    
    
    public function initUserAttributes(){
        
        
        
    }
    
}

?>