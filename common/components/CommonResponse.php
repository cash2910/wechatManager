<?php
namespace common\components;

use yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
class CommonResponse{
    static public function end($param) {
        $status = ArrayHelper::getValue($param, 'status_code', 200 );
        $type = ArrayHelper::getValue($param, 'resp_type','json');
        switch ($type){
            case 'json':
            default:
                $resp = new MyJsonResp();
                $resp->setData( $param );
                break;
        }
        yii::$app->end( $status, $resp );
    }
}

class MyJsonResp extends Response{
    
    public function setData( $data ){
        $this->data = $data;
        return $this;
    }
    
    public function send(){
         echo json_encode( $this->data ,JSON_UNESCAPED_UNICODE );
    }
}

?>