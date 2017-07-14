<?php
namespace common\components;

use yii;
use yii\helpers\ArrayHelper;
use common\components\WeixinAuthClient;
use common\service\BaseService;
/**
 * 微信配置方法
 * @author zaixing.jiang
 *
 */
class WeixinWeb extends BaseService{
    
    private $clientObj = null;
    
    public function getClient(){
        if( $this->clientObj == null )
            $this->clientObj = new WeixinAuthClient();
        return $this->clientObj;
    }
    
}

?>