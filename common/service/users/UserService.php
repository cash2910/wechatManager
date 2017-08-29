<?php
namespace common\service\users;

use common\service\UserInterface;
use common\service\BaseService;
use common\models\MgUsers;
use common\models\MgUserRel;
use common\models\MgUserProxyRel;

use yii;
use yii\helpers\ArrayHelper;
use common\models\MgUserAccount;


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
            if( !$uObj->save() )
                throw new \Exception( json_encode( $uObj->getErrors() ) );
            if( $callback != null ){
                $res['data']  = call_user_func( $callback, $uObj );
            }
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
    
    /**
     * 绑定上下级代理关系
     * @param MgUsers $touObj 上级用户
     * @param MgUsers $uObj   当前用户
     */
    public function bindProxyRel( MgUsers $touObj, MgUsers $uObj ){
        $ret = ['isOk'=>1, 'msg'=>'绑定成功'];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if( $uObj->is_bd == MgUsers::IS_BD )
                throw new \Exception('该用户已经为代理');
            $rel = !empty( $touObj->user_proxy_rels ) ? $touObj->user_proxy_rels.'-'.$touObj->id : (string)$touObj->id;
            $uids = explode('-', $rel);
            $uObj->user_proxy_rels = $rel;
            $uObj->rebate_ratio = 30;
            $uObj->is_bd = MgUsers::IS_BD;
            $uObj->proxy_pid = $touObj->id;
            if( !$uObj->save() ){
                throw new \Exception( json_encode( $uObj->getErrors() ) );
            }
            $relObj = new MgUserProxyRel();
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
    
    
    /**
     * 获取代理身份
     */
    static public function getProxyStatus( MgUsers $uObj ){
        $res = "";
        if( $uObj->is_bd == MgUsers::IS_PLAYER )
            return $res;
        $level = [
            ['推广员','30','35'],
            ['黄金代理','35','45'],
            ['白金代理','45','55'],
            ['总代理','55','99'],
        ];
        foreach ($level as $_level ){
            if( ( $uObj->rebate_ratio >= $_level[1] ) && $uObj->rebate_ratio <  $_level[2] ){
                $res = $_level[0];
                break;
            }
        }
        return $res;
    }
    
    /**
     * 判断是否为代理
     */
    static public function checkIsProxy( MgUsers $uObj ){
        return ($uObj->is_bd == MgUsers::IS_BD && $uObj->rebate_ratio >= 35);
    }
    
    /**
     * 先调整当前用户比例 、 在调整下级比例
     * @param MgUsers $uObj  被调整人
     * @param number $ratio  调整后比例
     */
    static public function changeRatio( MgUsers $uObj , $ratio = 30 ){
        $ret = ['isOk'=>1, 'msg'=>'调整完成'];
        $transaction = Yii::$app->db->beginTransaction();
        try{
            if( $uObj->is_bd != MgUsers::IS_BD )
                throw new \Exception("用户信息错误");
            if( $ratio < 30 )
                throw new \Exception("调整比例最低不能低于30%");
            $origin_ratio = $uObj->rebate_ratio;
            $uObj->rebate_ratio = $ratio;
            $uObj->save();
            if( $origin_ratio > $ratio ){
                //调整下级用户比例
                $proxys = static::getInstance()->getSubProxy( $uObj );
                $subList = [];
                foreach ( $proxys as $p ){
                    if( !isset($subList[$p->proxy_pid]) )
                        $subList[$p->proxy_pid] = [];
                     $subList[$p->proxy_pid][] = $p;
                }
                $ret = static::getInstance()->modifySubProxy( $subList[$uObj->id] , $subList, $ratio );
            }
            $transaction->commit();
        }catch(\Exception $e){
            $ret['isOk'] = 0;
            $ret['msg'] = $e->getMessage();
            $transaction->rollBack();
        }
        return $ret;
    }
    
    /**
     * 获取全部下级代理
     * @param MgUsers $uObj
     */
    static public function getSubProxy( MgUsers $uObj ){
        $rels = !empty( ArrayHelper::getValue($uObj, 'user_proxy_rels') ) ? $uObj->user_proxy_rels.'-'.$uObj->id : $uObj->id;
        $query = MgUsers::find()->where(['like','user_proxy_rels', "{$rels}%", false ]);
        return $query->all();
    }
    
    /**
     * 修改下级代理用户
     * 若代理用户返利低于调整后的 则不需要调整，若高于则调整为当前比例，并判断此代理的再下级代理
     * @param array $proxy
     * @param MgUsers $uObj
     * @param unknown $ratio
     */
    static public function modifySubProxy( $proxys ,&$subList, $ratio ){
        foreach ( $proxys as $p){
            if( $p->rebate_ratio <= $ratio )
                continue;
            $p->rebate_ratio = $ratio;
            $p->save();
            if( isset( $subList[$p->id] ) )
                static::getInstance()->modifySubProxy( $subList[$p->id] , $subList, $ratio  );
        }
    }

    
}

?>