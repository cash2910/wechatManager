<?php
namespace common\components;

use yii\helpers\ArrayHelper;
/**
 * 微信配置方法
 * @author zaixing.jiang
 *
 */
class WeixinConfig{
    
    //access_token 存储的key
    const TOKEN_KEY = 'WEIXIN_TOKEN';
    
    const WeiXinUrl = [
        'getAccessToken'=> [
            'url'=>'https://api.weixin.qq.com/cgi-bin/token',
            'need_token'=> false
        ],
        'getCallbackIp'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/getcallbackip',
        ],
        'getMenu' =>[
            'url'=> 'https://api.weixin.qq.com/cgi-bin/menu/get'
        ],
        'createMenu' =>[
            'url'=> 'https://api.weixin.qq.com/cgi-bin/menu/create',
            'isPost'=>1
        ],
        'getUserTag'=>[
            'url' =>'https://api.weixin.qq.com/cgi-bin/tags/get',
        ],
        'createUserTag'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/tags/create',
            'isPost'=>1
        ],
        'updateUserTag'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/tags/update',
            'isPost'=>1
        ],
        'deleteUserTag'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/tags/delete',
            'isPost'=>1
        ],
        'getUsers'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/user/get',
            'isPost'=>1
        ],
        'batchGetUsersInfo'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/user/info/batchget',
            'isPost'=>1
        ],
        'getUserInfo'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/user/info',
        ],
        'createQrcode'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/qrcode/create',
            'isPost'=>1
        ],
        'genShortUrl'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/shorturl',
            'isPost'=>1
        ],
        //设置行业类型
        'setIndustry'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/template/api_set_industry',
            'isPost'=>1
        ],
        'sendMsg'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/message/template/send',
            'isPost'=>1
        ],
        'createCs'=>[
            'url'=>'https://api.weixin.qq.com/customservice/kfaccount/add',
            'isPost'=>1
        ],
        'sendCsMsg'=>[
            'url'=>'https://api.weixin.qq.com/cgi-bin/message/custom/send',
            'isPost'=>1
        ],
        'getUserSummary'=>[
            'url'=>'https://api.weixin.qq.com/datacube/getusersummary',
            'isPost'=>1
        ],
        'getUserCumulate'=>[
            'url'=>'https://api.weixin.qq.com/datacube/getusercumulate',
            'isPost'=>1
        ]
    ];
    
    const WEIXIN_USER_INFO = ['openid','nickname','sex','language','city','province','country','headimgurl','subscribe_time','unionid','remark','tagid_list'];
    //根据ticket换取微信二维码地址
    const WX_QRCODE_URL = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=';
    //微信创建的二维码默认有效时间  2590000 最大
    const WX_QRCODE_DEFAULT_EXPIRED_TIME = 2590000;
    
    static function getConf( $key ) {
        return ArrayHelper::getValue( self::WeiXinUrl, $key );
    }
}

?>