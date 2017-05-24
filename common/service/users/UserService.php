<?php
namespace service\users;

use common\service\UserInterface;
use common\service\BaseService;
use common\models\MgUsers;

class UserService extends BaseService implements UserInterface
{

    //创建用户
    public function createUser( $params ){
        
        $uObj = new MgUsers();
        $uObj->open_id = $params['open_id'];
        $uObj->register_time = $params['add_time'];
        $uObj->is_bd = 1;
        if( !empty($params['event_key']) ){
            
        }
        $uObj->save();
    }
    
    //获取用户信息
    public function getUserInfo( $params = [] ){
        
        $query = MgUsers::find();
        if( !empty( $params ) ){
            $query->where( $params );
        }
        
        return $res;
    }
}

?>