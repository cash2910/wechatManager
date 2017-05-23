<?php
namespace common\service\weixin;

use common\models\WechatUserTag;
use yii;
use common\models\WechatUsers;
use common\models\WechatUserId;
use common\components\WeixinConfig;
use yii\helpers\ArrayHelper;
class BusinessService {
        
    /**
     * @param unknown $tags
     */
    public function initTag( $tags ){
      
        $date = date("Y-m-d H:i:s");
        foreach ( $tags as $k => &$tag ){
            $tag['add_time'] =  $date;
            $tag = array_values( $tag );
        }
        WechatUserTag::deleteAll();        
        $ret = yii::$app->db->createCommand()->batchInsert( WechatUserTag::tableName(),[
            'tag_id','tag_name','count','add_time'
        ],$tags)->execute();     
        return $ret;
    }
    
    
    /**
     * @todo 优化查询方式 修改为根据最后一页openid进行主键查询
     * 获取全部微信用户信息
     * 1、获取用户全部用户的openId
     * 2、根据openId获取用户详细信息并保存
     */
     public function initUsers(){
         
         ignore_user_abort(true);
         set_time_limit(0);
         WechatUsers::deleteAll();
         $total = $this->initOpenids();
         if( 0 == $total )
             return true; 
         $total = 9999;
         $psize = 100; $cur = 0;
         do{
             $ret = WechatUserId::find()->offset( ($cur++)*$psize )->limit( $psize )->all();
             $total -= $psize;
             $arr = array_map( function( $v ){
                 return [ 'openid'=>$v->open_id ];
             }, $ret );
             $res = WeChatService::getIns()->batchGetUsersInfo([
                 'user_list'=>$arr
             ]);
             if( 0 !== ArrayHelper::getValue($res, 'errcode', 0 ) )
                 return false;
             $this->addWeChatUsers( $res['user_info_list'] );
         }while( $total > 0 );
         return true;
     }
     
     private function addWeChatUsers( $uList ){
         $infos = array_map( function( $v ){
               $arr = [];
               foreach ( WeixinConfig::WEIXIN_USER_INFO as $attr ){
                    $_attr = ArrayHelper::getValue( $v, $attr, "" );
                    $arr[] = is_array( $_attr ) ? json_encode( $_attr ) : $_attr;
               }
               return $arr;
         }, $uList );
         //替换open_id
         $cols = WeixinConfig::WEIXIN_USER_INFO;
         $cols[0] = 'open_id';
         $ret = yii::$app->db->createCommand()->batchInsert( WechatUsers::tableName(), $cols, $infos )->execute();
     }
     
     /**
      * 从微信获取全部用户openids 并添加到数据库
      * @return unknown
      */
     public function initOpenids(){
          $this->clearOpenids();
          $nextid = '';
          $count = 0; $total = 0;
          do{
              $arg = empty( $nextid ) ? [] : ['next_openid'=>$nextid,];
              $ret = WeChatService::getIns()->getUsers($arg);
              $total = $ret['total'];
              $count += $ret['count'];  //当前页面总条数
              $nextid = $ret['next_openid'];
              $this->addOpenids(  $ret['data']['openid'] );
          }while( $total == $count );
          return $total;
     }
     
     private function clearOpenids( $condition = [] ){
         WechatUserId::deleteAll();
     }
     
     private function addOpenids( $oids, $condition= [] ){
         $oids = array_map( function( $v ){
             return (array)$v;
         }, $oids );
         $ret = yii::$app->db->createCommand()->batchInsert( WechatUserId::tableName(),[
            'open_id'
        ],$oids)->execute();     
     }
     
     

    
}

?>