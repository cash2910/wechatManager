<?php
namespace common\service;

/**
 * 微信相关接口
 * @author zaixing.jiang
 *
 */
interface WeixinInterface{
    
    /**
     * 基础支持-获取access_token
     */
    public function getAccessToken( $params );
    
    /**
     * 基础支持-获取微信服务器IP地址
     */
    public function getCallbackIp();

    /**
     * 查询菜单接口
     */
    public function getMenu();
    
    /**
     * 创建菜单
     * @param unknown $params
     */
    public function createMenu( $params );
    
    /**
     * 查询用户标签接口
     */
    public function getUserTag();
    
    /**
     * 创建用户标签接口
     */
    public function createUserTag( $params );
    
    /**
     * 编辑用户标签
     * @param unknown $params
     */
    public function updateUserTag( $params );
    
    /**
     * 删除用户标签
     * @param unknown $params
     */
    public function deleteUserTag( $params );
    
    /**
     * 获取微信关注用户 open_ids
     * @param unknown $params
     */
    public function getUsers( $params );
    

    /**
     * 获取微信关注用户
     * @param unknown $params
     */
    public function batchGetUsersInfo( $params );
    
    /**
     * 获取微信用户详细信息
     */
    public function getUserInfo( $params );
    
    /**
     * 生成带参数的二维码链接
     * @param unknown $params
     */
    public function createQrcode( $params );
    
    
    /**
     * 生成短链接url
     * @param unknown $params
     */
    public function genShortUrl( $params );
    
    /**
     * 设置行业模板
     * @param unknown $params
     */
    public function setIndustry( $params );
  
    /**
     * 发送行业模板
     */
    public function sendMsg( $params );
    
    /**
     * 添加客服账号
     */
    public function createCs( $params );
    
    /**
     * 发送客服消息
     */
    public function sendCsMsg( $params );
    
    /**
     * 获取用户增减数据
     */
    public function getUserSummary( $params );
    
    /**
     * 获取累计用户数据
     */
    public function getUserCumulate($params);

}

?>