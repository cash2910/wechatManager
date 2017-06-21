<?php

namespace backend\modules\Game;

/**
 * Game module definition class
 */
class GameModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\Game\controllers';

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
                ['label'=>'游戏管理','url' => ['/Game/game'], 'active' => 0 ],
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
