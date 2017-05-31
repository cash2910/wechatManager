<?php
namespace common\service;

use yii\base\Component;
class BaseService extends Component{
    
    static $models = [];
    static public function getInstance( $arg = null ){
        $name =  get_called_class();
        if( !isset( self::$models[$name] ) ){
            self::$models[$name] = new $name( $arg );
        }
        return self::$models[$name];
    }
    
}

?>