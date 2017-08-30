<?php
namespace common\components;

use common\service\weixin\WeChatService;
class Notify{
    
    private $records = [];
    
    public function record( $data ){
        $this->records[]  = $data;
    }
    
    public function notify( $params = [] ){
        
        if( empty( $this->records )  )
            return false;
        foreach ( $this->records as $record ){
            $res = WeChatService::getIns()->sendCsMsg([
                'touser'=> $record['open_id'] ,
                'msgtype'=>'text',
                'text'=>[
                    'content'=> $record['msg']
                ]
            ]);
        }
        return true;
    }
    
}

?>