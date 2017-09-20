<?php

namespace backend\modules\Order;
use yii;
use mdm\admin\components\Helper;

/**
 * Order module definition class
 */
class OrderModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\Order\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
    
    
    public function getMenu( $path ){
        $path = '/'.$path;
        //$ret = Helper::checkRoute('/Order/order/index');
        $items =  [
            'items' => [
                ['label'=>'订单管理','url' => ['/Order/order/index'], 'active' => 0 ],
                ['label'=>'提现管理','url' => ['/Order/rebate/index'], 'active' => 0 ],
                ['label'=>'账户信息','url' => ['/Order/account-log/index'], 'active' => 0 ],
                ['label'=>'返利余额','url' => ['/Order/profit/index'], 'active' => 0 ],
            ]
        ];
        //var_dump($ret);die();
        $func = function( &$items ) use ( &$func, $path ){
            foreach( $items as &$item ){
                if( !Helper::checkRoute( $item['url'][0] ) )
                    unset( $item );
                if( isset( $item['items'] ) ){
                    $func( $item['items'] );
                }elseif( strpos( $path, $item['url'][0] ) !== false ){
                    $item['active'] = 1;
                    return true;
                }
            }
        };
        $func( $items['items'] );
        return $items;
    }
}
