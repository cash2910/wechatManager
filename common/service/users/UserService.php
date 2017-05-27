<?php
namespace common\service\users;

use common\service\UserInterface;
use common\service\BaseService;
use common\models\MgUsers;

use yii;

class UserService extends BaseService implements UserInterface
{

    //创建用户
    public function createUser( $params, \Closure $callback = null ){
 
        $res = ['isOk'=>1,'msg'=>'创建用户成功'];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $uObj = new MgUsers();
            $uObj->setAttributes( $params );
            if( $callback != null ){
                $res['data']  = call_user_func( $callback, $uObj );
            }
            $ret = $uObj->save();
            if( !$ret )
                 throw new \Exception( json_encode( $uObj->getErrors() ) );
            $transaction->commit();
        }catch ( \Exception $e){
            $res['isOk'] = 0;
            $res['msg'] = $e->getMessage();
            yii::error(  $res['msg'] );
            $transaction->rollBack();
        }
        return $res;
    }
    
    //获取用户信息
    public function getUserInfo( $params = [] ){
        $query = MgUsers::find();
        if( !empty( $params ) ){
            $query->where( $params );
        }
        return $query->one();
    }
    
    //修改用户信息
    public function modifyUser( $params, \Closure $callback = null ){
    
        $res = ['isOk'=>1,'msg'=>'修改用户信息成功'];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $uObj = new MgUsers();
            $uObj->setAttributes( $params );
            if( $callback != null ){
                $res['data']  = call_user_func( $callback, $uObj );
            }
            $ret = $uObj->save();
            if( !$ret )
                throw new Exception( $uObj->getErrors() );
            $transaction->commit();
        }catch (Exception $e){
            $res['isOk'] = 0;
            $res['msg'] = $e->getMessage();
            $transaction->rollBack();
        }
        return $res;
    }
}

?>