<?php
namespace common\service\users;

use common\service\UserInterface;
use common\service\BaseService;
use common\models\MgUsers;
use common\models\MgUserRel;

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
 
        $res = ['isOk'=>1,'msg'=>'创建用户成功','data'=>[]];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            $uObj = new MgUsers();
            $uObj->setAttributes( $params );
            if( $callback != null ){
                $res['data']  = call_user_func( $callback, $uObj );
            }
            if( !$uObj->save() )
                 throw new \Exception( json_encode( $uObj->getErrors() ) );
            $res['data']['user'] = $uObj;
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
        yii::error( "rels:".$rels);
        $query = MgUsers::find()->where(['like','user_rels', "{$rels}%", false ]);
        if(  0 !== $limit  ){
            $query->limit( $limit );
        }
        return $query->all();
    }
    
    
    /**
     * 绑定上下级关系
     * @param MgUsers $touObj 上级用户
     * @param MgUsers $uObj   当前用户
     */
    public function bindRel( MgUsers $touObj, MgUsers $uObj ){
        $ret = ['isOk'=>1, 'msg'=>'绑定成功'];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if( !empty($uObj->user_rels) )
                throw new \Exception('该用户已绑定上级');
            $rel = !empty( $touObj->user_rels ) ? $touObj->user_rels.'-'.$touObj->id : (string)$touObj->id;
            $uids = explode('-', $rel);
            if( in_array($uObj->id, $uids) )
                throw new \Exception('不能绑定到下级用户');
            if( !empty( $this->getUserFriend($uObj,1) ) )
                throw new \Exception("用户{$uObj->nickname}已经有下级了");
            $uObj->user_rels = $rel;
            if( !$uObj->save() ){
                throw new \Exception( json_encode( $uObj->getErrors() ) );
            }
            $relObj = new MgUserRel();
            $relObj->user_id = $touObj->id;
            $relObj->sub_user_id = $uObj->id;
            $relObj->user_openid = $touObj->open_id;
            $relObj->sub_user_openid = $uObj->open_id;
            if( !$relObj->save() )
                throw new \Exception( json_encode( $relObj->getErrors() ) );
            $transaction->commit();
        }catch( \Exception $e ){
            $transaction->rollBack();
            $ret['isOk'] = 0 ;
            $ret['msg'] = $e->getMessage();
        }
        return $ret;
    }
    

    
}

?>