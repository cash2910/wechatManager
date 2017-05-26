<?php
namespace common\components;

use yii\helpers\ArrayHelper;
/**
 * 微信菜单配置内容
 * @author zaixing.jiang
 *
 */
class WeixinMenuConfig{
    
    public static $conf = [
        //获取推广链接
        'GET_SHARE_QRCODE'=>[
            'title'=>'获取推广链接',
            'handle'=>[
                'class'=> 'common\service\weixin\BusinessService',
                'method'=>'getUserShareCode',
            ]
        ],
        'MY_GAME'=>[
            'title'=>'我的游戏',
            'handle'=>[
                'class'=> 'common\service\weixin\BusinessService',
                'method'=> 'getGames'
            ]
        ]
    ];
    
    static public function getConf( $key ){
        return ArrayHelper::getValue(self::$conf, $key.".handle", "");
    }
    
}

?>