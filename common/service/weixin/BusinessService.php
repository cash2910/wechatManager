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
use common\models\MgGames;
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
     * 3、当isupdate为false为重新同步数据 ，默认为同步新增用户到本地
     */
     public function initUsers( $isUpdate = true ){
         
         ignore_user_abort(true);
         set_time_limit(0);
         if( !$isUpdate )
            WechatUsers::deleteAll();
         $hasNew = $this->initOpenids( $isUpdate );
         if( !$hasNew )
             return false;
         $cur_id = 0;
         $last = WechatUsers::find()->orderBy('id desc')->one();
         if( $last ){
              $info  = WechatUserId::findOne(['open_id'=>$last->open_id]);
              $cur_id = $info->id;
         }
         //$psize最大值为100，此为微信一次最大拉取数量
         $psize = 100; $cur = 0;
         do{
             $ret = WechatUserId::find()->where("id > $cur_id")->offset( ($cur++)*$psize )->limit( $psize )->all();
             if( empty($ret) )
                 break;
             $arr = array_map( function( $v ){
                 return [ 'openid'=>$v->open_id ];
             }, $ret );
             $res = WeChatService::getIns()->batchGetUsersInfo([
                 'user_list'=>$arr
             ]);
             $this->addWeChatUsers( $res['user_info_list'] );
         }while( true );
         return true;
     }
     
     /**
      * 从微信获取全部用户openids 并添加到数据库
      * @return unknown
      */
     public function initOpenids( $isUpdate = true ){
         if( !$isUpdate )
             $this->clearOpenids();
         $hasNew = false;
         $last = WechatUserId::find()->orderBy('id desc')->limit(1)->one();
         if( $last )
            $nextid = $last->open_id;
         do{
             $arg = empty( $nextid ) ? [] : ['next_openid'=>$nextid];
             $ret = WeChatService::getIns()->getUsers($arg);
             if( !ArrayHelper::getValue( $ret, 'next_openid' ) )
                 break;
             $hasNew = true;
             $nextid = $ret['next_openid'];
             $this->addOpenids(  $ret['data']['openid'] );
         }while( true );
         return $hasNew;
     }
     
     /**
      * 从微信出获取新增的用户信息并保存到本地
      */
     public function getNewUsers( $from_openid = '' ){
         if( empty($from_openid) ){
             $res = WechatUserId::find()->orderBy('id desc')->limit(1);
             $from_openid = $res->open_id;
         }
         
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
     public function getUserShareCode( ProxyXml $entity ){
   
         $uInfo = UserService::getInstance()->getUserInfo([
             'open_id'=> $entity->FromUserName
         ]);
         
         $entity->setResp([
             'FromUserName'=>$entity->ToUserName,
             'ToUserName'=>$entity->FromUserName,
             'MsgType'=>'news',
             'ArticleCount'=>1,
             'Articles'=>[
                 ['item'=>[
                     'Title'=>'您有如下专属推广链接',
                     'Description'=>'点击进入专属页面',
                     //'PicUrl'=> 'http://imgtg.37wan.com/u/2017/0508/081112549ctt7.jpg',
                     'Url' => Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/default/share-page', 'id'=>$uInfo->id] )
                 ]]
             ]
         ]);
     }
     
     /**
      * 根据用户id 生成推广二维码
      * @param unknown $entity
      * @return string
      */
     public function getQrcode( $id ,
         $eternal = false //是否生成永久二维码
     ){
         if( $eternal && $id > 100000 ){
             throw new Exception('exceed max limit 10000');
         }
         $key = sprintf("mg_user_shareqrcode_url_%s", $id);
         $type = $eternal ? 'QR_LIMIT_STR_SCENE' : 'QR_SCENE';
         if( !( $url = yii::$app->redis->get( $key ) ) ){
             $ret = WeChatService::getIns()->createQrcode([
                 'expire_seconds'=> WeixinConfig::WX_QRCODE_DEFAULT_EXPIRED_TIME,
                 'action_name' => $type,
                 'action_info' =>[
                     'scene'=>[
                         'scene_id'=> $id , // $id ,
                     ]
                 ]
             ]);
             if( !isset( $ret['ticket'] ) )
                 throw new Exception('failed to get qrcode');
             $url = WeixinConfig::WX_QRCODE_URL. $ret['ticket'] ;
             $url = $this->getShortUrl( $url );
             if( empty( $url ) )
                 throw new Exception('failed to get short url');
             yii::$app->redis->set( $key, $url , 'EX', WeixinConfig::WX_QRCODE_DEFAULT_EXPIRED_TIME );
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
     
     
     //微信获取游戏信息  
     public function getGames( ProxyXml $entity  ){
         
         $games = MgGames::find()->where([
             'status'=> MgGames::IS_ONLINE
         ])->all();
         $total = 0;
         $data = [];
         foreach ($games as $gObj){
             $data[]=['item'=>[
                'Title'=>$gObj->title,
                'Description'=>$gObj->desc,
                'PicUrl'=>$gObj->pic_url,
                'Url'=> !empty( $gObj->url ) ? $gObj->url : Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/default/game-page','id'=>$gObj->id] ),
             ]];
             $total++;
         }
         $entity->setResp([
             'FromUserName'=>$entity->ToUserName,
             'ToUserName'=>$entity->FromUserName,
             'MsgType'=>'news',
             'ArticleCount'=> $total,
             'Articles'=> $data
          ]);
     }
     
     public function consultCs( ProxyXml $entity ){
         $entity->setResp([
             'FromUserName'=>$entity->ToUserName,
             'ToUserName'=>$entity->FromUserName,
             'MsgType'=>'news',
             'ArticleCount'=>1,
             'Articles'=>[
                 ['item'=>[
                     'Title'=>'回复“咨询客服” 即可在线沟通',
                     'Description'=>'回复“咨询客服” 即可在线沟通',
                     'PicUrl'=> 'https://mmbiz.qlogo.cn/mmbiz_png/bOWzAibGJ912OrqyGpYBtt6fK6QCwvZ88bgZJknrJZ0rceoGt6Z2Z9lWCPRywdTVicGqaalqHba0ZdwDGohzIfcg/0?wx_fmt=png',
                     'Url' =>"https://mp.weixin.qq.com/s?__biz=MzI3OTY5NzA2Mg==&mid=100000001&idx=1&sn=39f7eb4ad4dee2b8930cc5f289a2ebb6&chksm=6b4282c85c350bde33257163a048bd0ce112d0f72888f828a2e4d57d0a16104cc1bd0f8c3bb3&scene=0&pass_ticket=6hnexhCFLQhTLCFfAZuY44AwWCS5jdCtqOZP9AN%2F29k7hDlwwWlGz1WlFlp0i2uL#rd"
                 ]],
             ]
         ]);
     }
    
}

?>