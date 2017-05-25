<?php
namespace common\service\weixin;

use common\models\WechatUserTag;
use yii;
use common\models\WechatUsers;
use common\models\WechatUserId;
use common\components\WeixinConfig;
use yii\helpers\ArrayHelper;
use common\service\BaseService;
use yii\base\Exception;
use common\service\users\UserService;
class BusinessService extends BaseService{
        
    /**
     * 获取微信用户标签并保存到数据库
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
     
     /**
      * 获取二维码信息
      * @param unknown $id
      * @param unknown $entity
      */
     public function getUserShareCode( $id, $entity ){
         
         $id = $entity->EventKey;
         $url = $this->getQrcode($id);
         $uInfo = UserService::getInstance()->getUserInfo([
             'id'=> $id
         ]);
         $entity->setResp([
             'ToUserName'=> $uInfo->open_id,
             'MsgType'=>'image',
             'Image'=>[
                 'MediaId'=>'xxx',
             ]
         ]);
         
     }
     
     /**
      * 根据用户id 生成推广二维码
      * @param unknown $entity
      * @return string
      */
     public function getQrcode( $entity ,
         $eternal = false //是否生成永久二维码
     ){
         $id = $entity['id'];
         $key = sprintf("mg_user_shareqrcode_url_%s", $id);
         if( !( $url = yii::$app->redis->get( $key ) ) ){
             $ret = WeChatService::getIns()->createQrcode([
                 'expire_seconds'=> WeixinConfig::WX_QRCODE_DEFAULT_EXPIRED_TIME,
                 'action_name' => 'QR_SCENE',
                 'action_info' =>[
                     'scene_id'=> str_pad( decbin( $id ), 32 , 0, STR_PAD_LEFT ),
                 ]
             ]);
             if( !isset( $ret['ticket'] ) )
                 throw new Exception('failed to get qrcode');
             $url = WeixinConfig::WX_QRCODE_URL. $ret['ticket'] ;
             $url = $this->getShortUrl( $url );
             if( empty( $url ) )
                 throw new Exception('failed to get short url');
             yii::$app->redis->set( $key, $url , 'EX', time()+WeixinConfig::WX_QRCODE_DEFAULT_EXPIRED_TIME );
         }
         return $url;
     }
     
     //通过微信获取短链接
     public function getShortUrl( $url ){
         $ret = WeChatService::getIns()->genShortUrl([
             'action'=>'long2short',
             'long_url'=>$url
         ]);
         return ArrayHelper::getValue($ret, 'short_url', '');
     }
     

    
}

?>