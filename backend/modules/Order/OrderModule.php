<?php

namespace backend\modules\Order;

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
        $items =  [
            'items' => [
                ['label'=>'订单管理','url' => ['/Order/order'], 'active' => 0 ],
                ['label'=>'提现管理','url' => ['/Order/rebate'], 'active' => 0 ],
                ['label'=>'账户信息','url' => ['/Order/account-log'], 'active' => 0 ],
            ]
        ];
        $func = function( &$items ) use ( &$func, $path ){
            foreach( $items as &$item ){
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
