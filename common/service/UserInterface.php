<?php
namespace common\service;

/**
 * 用户相关接口
 * @author zaixing.jiang
 *
 */
interface UserInterface{
    
    /**
     * 创建用户接口
     */
    public function createUser( $params );
    
}

?>