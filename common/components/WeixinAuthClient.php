<?php
namespace common\components;
use yii;
use yii\authclient\OAuth2;

class WeixinAuthClient extends OAuth2{
    
    public $authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize';
    public $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token';
    
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
        $token = $this->createToken(['params' => [
            'oauth_token'=>$response['access_token'],
            'expir'=> 7000
        ]]);
        $this->setAccessToken($token);
        
        return $token;
        
    }
    
    
    public function refreshAccessToken(OAuthToken $token)
    {
        $url = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat'] );
        $wbServ =  $this->setReturnUrl( $url );
        Yii::$app->getResponse()->redirect($url);
    }
    
    
    
    
    public function initUserAttributes(){}
    
}

?>