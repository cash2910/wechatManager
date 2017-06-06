<?php
namespace common\service;

use yii\base\Component;
class BaseService extends Component{
    
    static $models = [];
    static public function getInstance(){
        $name =  get_called_class();
        if( !isset( self::$models[$name] ) ){
            $args = func_get_args();
            $class = new \ReflectionClass( $name );
            self::$models[$name] = $class->newInstanceArgs($args);
        }
        return self::$models[$name];
    }
    
}

?>