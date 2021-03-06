<?php

namespace backend\modules\Wechat\controllers;

use yii;
use yii\web\Controller;
use common\components\WeixinMenuConfig;
use common\service\weixin\WeChatResponseService;
use yii\helpers\ArrayHelper;
use common\service\users\UserService;
use common\service\weixin\WeChatService;
use common\service\weixin\BusinessService;
use common\service\weixin\GameService;
use common\service\weixin\ProxyXml;
use yii\base\Behavior;
use yii\base\Component;
use yii\base\Object;
use common\models\MgOrderList;
use common\components\game\Stone;
use common\components\wxtransfer\WeixinTrans;
use common\models\TransferEntity;
use common\components\wxtransfer\WeixinTransfer;
use common\service\order\RebateService;
use common\models\MgUserAccount;
use common\components\CommonResponse;


/**
 * Default controller for the `WeChat` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    /**
     * 获取最近7天用户变化信息
     */
    public function actionGetCumulate(){
        
        $from = date('Y-m-d', strtotime("-7 day") );
        $to = date('Y-m-d', strtotime("-1 day"));
        $ret = WeChatService::getIns()->getUserCumulate([
            'begin_date'=> $from,
            'end_date'=> $to,
        ]);
        $data = [];
        $arr = ArrayHelper::getValue($ret, 'list');
        if( !empty( $arr ) ){
            $_arr = array_column( $arr ,'cumulate_user','ref_date');
            $data['series'] = array_keys($_arr);
            $data['sum'] = array_values($_arr);
        }
        CommonResponse::end( $data );
    }
    
    //设置行业模板
    public function actionSetTpl(){
        
        $ret = WeChatService::getIns()->setIndustry([
            'industry_id1'=>1,
            'industry_id2'=>6
        ]);
        //var_dump( $ret );
    }
    
    
    
    
    public function actionTest(){
        // $token = WeChatProxyService::getToken();
       // var_dump($token);
        /*
         $ret = WeChatService::getIns()->getAccessToken([
            'grant_type'=>'client_credential',
            'appid'=> yii::$app->params['AppId'] ,
            'secret'=>yii::$app->params['AppSecret']
        ]);
        var_dump($ret); 
        */
       // $ret = WeChatService::getIns()->getCallbackIp();
/*          $ret = WeChatService::getIns()->getMenu();
        print_r($ret); 
        //修改微信标签
          $arr = [
            'tag'=>[
                'name'=> 'vip2'
            ]
        ] ; */
/*       $ret = WeChatService::getIns()->updateUserTag([
                'tag'=>[
                    'id'=>106,
                    'name'=> 'vip11'
                ]
         ]);
          */
/*         $ret = WeChatService::getIns()->getUsers([
            
        ]); */
/*         $ret = WeChatService::getIns()->batchGetUsersInfo([
            'user_list'=>[
                ["openid"=> "oVM_Gt9udjlsp1U7t7sf0HPTERhk"],
                ["openid"=> "oVM_Gt4StRL6Cl2lh-34L5v_UruA"],
                ["openid"=> "oVM_Gt7OR4qXOMeSMN7DBL_eCMKo"]
            ]
        ]); */
        // var_dump($ret); 
        //生成临时二维码
/*         $ret = WeChatService::getIns()->createQrcode([
            'expire_seconds'=> 1400,
            'action_name' => 'QR_SCENE',
            'action_info' =>[
                'scene_id'=> str_pad( decbin(12), 32 , 0, STR_PAD_LEFT ),
            ]
        ]); */
      //  var_dump($ret);die();
/*         $id = 18; //'event_key'=>$entity->EventKey,
        $ret = UserService::getInstance()->createUser([
            'add_time'=> time(),
            'open_id' => '4546464646aaa',
            'ticket' => 'dsadsa'
        ],function( $model ) use ( $id ){
            $uInfo = UserService::getInstance()->getUserInfo([
                'id'=> $id
            ]);
            $rel = $uInfo->user_rels;
            $model->user_rels = $rel."-".$uInfo->id;
            $model->on( ActiveRecord::EVENT_AFTER_INSERT, function( $ent ) use ( $id ){
                $rel = new MgUserRel();
                $rel->user_id = $id;
                $rel->sub_user_id = $ent->sender->id;
                $rel->save();
            });
        }); */
        
/*         $conf  = WeixinMenuConfig::getConf( 'GET_SHARE_QRCODE' );
        if( empty($conf) ){
            die('...');
        }
        $ret = call_user_func_array([new $conf['class'], $conf['method']], [16]); */
        //echo  Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/default/share-page', 'id'=>555] );
        //$ret = UserService::getInstance()->checkExist( '321321' );
/*         $ret = UserService::getInstance()->modifyUser([
            'id'=> 11,
            'status'=> 2,
        ]); */
        
 /*        $ret = WeChatService::getIns()->sendMsg([
            'touser'=>'opjR8w4dyynJRHFhL8fFY9yrYG8M',
            'template_id'=>'8g7uVLKEUDPalyxX3nXoBAlAbKaktmdkjh8itzlbXAk',
           // 'url'=>'',
            'data'=>[
                'first'=>[
                    'value'=>'恭喜您通过分享链接成功锁定一位会员！',
                    'color'=>'#173177'
                ],
                'keyword1'=>[
                    'value'=>'刘德华',
                    'color'=>'#173177'
                ],
                'keyword2'=>[
                    'value'=>date('Y-m-d H:i:s'),
                    'color'=>'#173177'
                ],
                'remark'=>[
                    'value'=>'记得提醒他多关注平台。',
                    'color'=>'#173177'
                ]
            ]
        ]); */
        
/*        $ret = WeChatService::getIns()->getUserInfo([
           'openid'=>'opjR8w4dyynJRHFhL8fFY9yrYG8M'
       ]); */
/*         $ret = WeChatService::getIns()->createCs([
            'kf_account'=>"test1@test",
            'nickname'=>'客服老王'
        ]);
 */        
   //     $ret = BusinessService::getInstance()->initUsers();
   
      //  $ret = BusinessService::getInstance()->getGames( );
/*          $ret = WeChatService::getIns()->sendCsMsg([
            'touser'=>"o9Unv0a0sL-H8lREpQ86O5WodVyg",
            'msgtype'=>'text',
            'text'=>[
                'content'=>'哇哈哈'
            ]
        ]);
       
        var_dump( $ret ); */

     //      $ret =  Stone::getInstance()->addStone( 1000552 , 100);
           //var_dump( $ret );
/*         $order = MgOrderList::findOne([
            'order_sn'=>'20170622142723131378'
        ]);*/
/*         $order = MgOrderList::findOne(['order_sn'=>'20170622110201231271']);
        $m = new My();
        $m->go( $order );  */
        
        //微信支付给用户
/*         $entity = new TransferEntity();
        $entity->setAttributes([
            'partner_trade_no'=>'dsasdad311saa',
            'openid'=>'o9Unv0a0sL-H8lREpQ86O5WodVyg',
            'check_name'=>'NO_CHECK',
            'amount'=>100,
            'desc'=>'等级考试架空了',
            'spbill_create_ip'=>'127.0.0.1',
        ]);
        $tObj = new WeixinTransfer();
        $ret = $tObj->setData($entity)->doTransFer(); */
/*         $aObj = MgUserAccount::findOne(['user_id'=>11]);
        $ret = RebateService::getInstance()->createRebateOrder( $aObj , 5 );
        var_dump( $ret ); */

    }
}