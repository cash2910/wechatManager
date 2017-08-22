<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use common\service\weixin\BusinessService;
use yii;
use common\components\WeixinWeb;
use common\components\WeixinLoginBehavior;
use common\models\MgUsers;
use common\models\MgUserRel;
use common\service\game\GameService;
use common\models\MgOrderList;
use common\models\MgUserAccount;
use common\models\MgUserAccountLog;
use common\models\MgGames;
use common\components\CommonResponse;
use common\service\users\UserService;
use common\service\order\OrderService;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `Wechat` module
 */
class DefaultController extends Controller
{
    public $layout = "main_wx";
    public $title ;
    public $open_id = '';
    
    public function behaviors(){
        return [
            'access' => [
                'class' => WeixinLoginBehavior::className(),
                'actions' => [
                    'my-index','my-friend','my-order','my-charge','my-wallet', 'game-page' ,'my-rebates' , 'share-page', 'friends-charge','room-page','friend-info'
                ],
            ]
        ];
    }
    
    /**
     * Renders the index view for the module
     * @return string 
     */
    public function actionIndex()
    {
        if( !( $code = yii::$app->request->get('code') ) ){
            die('访问受限 。');
        }
        $token = WeixinWeb::getInstance()->getClient()->fetchAccessToken( $code );

        Yii::$app->getResponse()->redirect( Yii::$app->request->get('r_url', '/Wechat/default/my-index') );
    }
    
    public function actionSharePage()
    {
        $gObj = MgGames::findOne(['id'=>yii::$app->request->get('gid', 1)]);
        if( !$gObj )
            die('游戏信息错误');
        //判断用户是否关注
        $uObj = MgUsers::findOne([
            'open_id'=>$this->open_id,
            'status'=>MgUsers::IS_SUBSCRIPT
        ]);
        //判断是否为本人访问
        $owner = false;
        if( $uObj && ( $uObj->id == Yii::$app->request->get('id') ) )
            $owner = true;
        
        return $this->renderPartial('share_page',[
            'gInfo'=> $gObj,
            'uObj' => $uObj,
            'owner' => $owner
        ]);
    }
    
    public function actionGamePage()
    {
        $gObj = MgGames::findOne(['id'=>yii::$app->request->get('id', 1)]);
        if( !$gObj )
           die('信息错误');
        return $this->renderPartial('game_page',[
            'gInfo'=> $gObj
        ]);
    }
    
    /**
     * MG推广首页
     * @return string
     */
    public function actionMyIndex()
    {
        $this->title = 'MG首页';
        //判断用户是否为mg用户   
        $mgInfo = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $mgInfo == null ){
            die('访问受限');
        }
        return $this->render('my_index',[
            'user'=>$mgInfo
        ]);
    }
    
    //我的下线列表
    public function actionMyFriend()
    {
        $this->title = '我的好友';
        $mgInfo = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $mgInfo == null ){
            die('访问受限');
        }
        $ids = [];
        $subObjs = MgUserRel::findAll( ['user_id'=>$mgInfo->id] );
        foreach( $subObjs as $subObj){
            $ids[] = $subObj->sub_user_id;
        }
        $role = yii::$app->request->get('role', MgUsers::IS_PLAYER );
        $subs = MgUsers::findAll( [ 'id'=>$ids,'is_bd'=>$role ] );
        return $this->render('my_friend', [
            'subs'=> $subs,
            'role'=> $role
        ]);
    }
    
    
    //我的下线列表
    public function actionFriendInfo()
    {
        $this->title = '我的好友';
        $mgInfo = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $mgInfo == null ){
            die('访问受限');
        }
        if( !($friend_id = yii::$app->request->get('id', 0) )  )
            die('用户id为空');
        $friendObj = MgUsers::findOne( ['id'=>$friend_id] );
        if( !$friendObj )
            die('好友不存在');
        //判断是否为自己的好友
        $rels = explode("-",$friendObj->user_rels);
        $pid = array_pop( $rels );
        if( $pid != $mgInfo->id )
            die('好友不存在');
        return $this->render('friend_info', [
            'fObj'=> $friendObj,
        ]);
    }
    
    //我的订单列表
    public function actionMyCharge()
    {
        $this->title="游戏充值";
        $gid = yii::$app->request->get('game_id',1);
        $goods = GameService::getInstance()->getGameGoods( $gid );
        return $this->render('my_charge',[
            'goods'=>$goods
        ]);
    }
    
    //我的订单列表
    public function actionMyOrder()
    {
        $this->title="我的订单";
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        $orderList = MgOrderList::find()->where(['user_id'=>$uObj->id])->andWhere(['<>','pay_sn',' '])->orderBy("update_time desc")->all();
        return $this->render('my_order',[
            'order_list'=>$orderList
        ]);
    }
    
    
    //我的提现
    public function actionMyWallet()
    {
        $this->title="提现管理";
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        $uaObj = MgUserAccount::findOne(['user_id'=>$uObj->id]);
        return $this->render('my_wallet',[
            'account' => $uaObj
        ]);
    }
    
    //我的提现
    public function actionMyRebates()
    {
        $this->title="提现明细";
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        $aList = MgUserAccountLog::find()->where(['user_id'=>$uObj->id])->orderBy("add_time desc")->all();
        return $this->render('my_rebates',[
            'account_list'=> $aList
        ]);
    }
    
    /**
     * 游戏房间分享页面
     * 1、若分享者信息不存在。跳转官方默认推广员推广地址
     * 2、若点击分享页面用户没有关注公众号，跳转到分享用户专属链接页
     * 3、若1、2都不满足，则显示房间信息页
       echo json_encode([
            'Room_id'=>12121,
            'Title'=>'人人麻将：房间号[756 433] ',
            'Desc'=>'4局、3番封顶,1底分 赶快来！',
            'Time'=>1503364468
        ],JSON_UNESCAPED_UNICODE);die(); 
     * @return string
     */
    public function actionRoomPage()
    {
        $uObj = MgUsers::findOne(['union_id'=>yii::$app->request->get('union_id')]);
        if( !$uObj ){
            return $this->redirect(['/Wechat/default/share-page','id'=>yii::$app->params['DEFAULT_USER']]);
        }
        $viewUser = MgUsers::findOne( [ 'open_id'=>$this->open_id, 'status'=>MgUsers::IS_SUBSCRIPT ] );
        if( !$viewUser ){
            return $this->redirect(['/Wechat/default/share-page','id'=>$uObj->id]);
        }
        $gObj = MgGames::findOne(['id'=>yii::$app->request->get('id', 1)]);
        if( !$gObj )
            die('信息错误');
        
        $roomInfo = json_decode( yii::$app->request->get('data') ,true );
        return $this->renderPartial('room_page',[
            'gInfo'=> $gObj,
            'uInfo'=> $uObj,
            'roomInfo'=> $roomInfo
        ]);
    }
    
    
    //我的提现
    public function actionFriendsCharge()
    {
        $this->title="好友充值";
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        $uList = UserService::getInstance()->getUserFriend( $uObj );
        $uids = [];
        foreach ($uList as $_uObj ){
           $uids[] = $_uObj->id;
        }
        $orderList = OrderService::getInstance()->getPaymentListByUids( $uids );
        $sum = 0.00;
        if( $orderList ){
            foreach ($orderList as $order ){
               $sum += $order->order_num;
            }
        }
        return $this->render('friend_charge_list',[
            'order_list'=> $orderList,
            'sum' => $sum,
            'user_map' => ArrayHelper::index($uList, null, 'id')
        ]);
    }
    
    
    /**
     * 获取二维码
     */
    public function actionGetQrCode(){
        $id = yii::$app->request->get('id', 0);
        $url = BusinessService::getInstance()->getQrcode( $id );
        CommonResponse::end([
            'isOk'=> 1,
            'msg' => '获取成功',
            'pic_url'=>$url
        ]);
    }
}
