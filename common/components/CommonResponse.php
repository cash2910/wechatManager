<?php
namespace common\components;

use yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
class CommonResponse{
    static public function end($param) {
        $status = ArrayHelper::getColumn($param, 'status_code', 200 );
        $type = ArrayHelper::getColumn($param, 'resp_type','json');
        switch ($type){
            case 'json':
            default:
                $resp = new MyJsonResp();
                $resp->send( $param );
                break;
        }
        yii::$app->end( $status, $resp );
    }
}

class MyJsonResp extends Response{
    
    private $data = [];
    
    public function setData( $data ){
        $this->data = $data;
    }
    
    public function send(){
         return json_encode( $this->data ,JSON_UNESCAPED_UNICODE );
    }
}

?>