<?php
namespace common\service\users;

use common\service\UserInterface;
use common\service\BaseService;
use common\models\MgUsers;

use yii;
use yii\helpers\ArrayHelper;

class UserService extends BaseService implements UserInterface
{
    
    //检测用户是否存在
    public function checkExist( $open_id ){
        return ( MgUsers::findOne([
            'open_id'=>$open_id
        ]) ) !== null;
    }

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
            yii::error(  json_encode($ret) );
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
    
    /**
     * 根据open_id和id 修改用户信息
     * @param unknown $params
     * @param \Closure $callback
     * @throws Exception
     * @return multitype:number string NULL
     */
    public function modifyUser( $params, \Closure $callback = null ){
    
        $res = ['isOk'=>1,'msg'=>'修改用户信息成功'];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if (isset($params['open_id'])) {
                 $uObj = MgUsers::findOne( [ 'open_id'=>$params['open_id'] ] );
            }else
               $uObj = MgUsers::findOne( $params['id'] );
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
    
    /**
     * 获取用户全部下线信息
     */
    public function getUserFriend( MgUsers $uObj , $limit = 0 ){
        $rels = !empty( ArrayHelper::getValue($uObj, 'user_rels') ) ? $uObj->user_rels.'-'.$uObj->id : $uObj->id;
        $query = MgUsers::find()->where(['like','user_rels', "{$rels}%", false ]);
        if(  0 !== $limit  ){
            $query->limit( $limit );
        }
        return $query->all();
    }
    

    
}

?>