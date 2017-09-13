<?php
namespace common\service\weixin;

use yii;
use common\service\BaseService;

class WeChatMsgService extends BaseService{
    
    /**
        {{first.DATA}}
                类型：{{keyword1.DATA}}
                等级：{{keyword2.DATA}}
                范围：{{keyword3.DATA}}
                详情：{{keyword4.DATA}}
        {{remark.DATA}}
     * @var unknown
     */
    const NOTIFY_TPL = 'gMQn9HidmLF0wBtBMwDkRkFV_W-2skb4dJ0Dywf_05g';
    
    private $proxy = null;
    
    public function __construct( WeChatService $proxy = null ){
        $this->proxy = $proxy;             
    }
    
    public function notify( $data ){
        $data += ['template_id'=>self::NOTIFY_TPL ];
        $ret = $this->proxy->sendMsg($data);
        return $ret;
    }
    
    
}

?>