<?php
namespace common\service;

/**
 * 用户相关接口
 * @author zaixing.jiang
 *
 */
interface OrderInterface{
    
    /**
     * 创建订单
     */
    public function createOrder( $params );
    
    /**
     * 更新订单
     */
    public function updateOrder( $params );
    
}

?>