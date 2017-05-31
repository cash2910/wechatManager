<?php
namespace common\service\weixin;

use yii;
use common\service\BaseService;

class WeChatMsgService extends BaseService{
    
    const SHARE_SUCCESS_TPL = '8g7uVLKEUDPalyxX3nXoBAlAbKaktmdkjh8itzlbXAk';
    
    private $proxy = null;
    
    public function __construct( WeChatService $proxy = null ){
        $this->proxy = $proxy;             
    }
    
    public function shareSuccess( $data ){
        $data += ['template_id'=>self::SHARE_SUCCESS_TPL ];
        $ret = $this->proxy->sendMsg($data);
        return $ret;
    }
    
    
}

?>