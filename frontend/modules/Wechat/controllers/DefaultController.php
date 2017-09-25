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
use yii\web\HttpException;
use common\models\MgUserProxyRel;
use common\service\weixin\WeChatService;
use common\models\MgRebateList;

/**
 * Default controller for the `Wechat` module
 */
class DefaultController extends Controller
{
    public $layout = "main_wx";
    public $title ;
    public $open_id = '';
    public $user_data = [];
    
    public function behaviors(){
        return [
            'access' => [
                'class' => WeixinLoginBehavior::className(),
                'actions' => [
                    'my-index','my-friend','my-order','my-charge','my-wallet', 'input-money','game-page' ,
                    'my-rebates' , 'share-page', 'friends-charge','room-page','friend-info','share-proxy','show-proxy-link','bind-proxy',
                    'my-proxy','proxy-info','change-ratio'
                ],
                'detail_actions'=>['show-proxy-link','bind-proxy']  //需要用户授权
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
            $this->_404('访问受限 。');
        }
        $token = WeixinWeb::getInstance()->getClient()->fetchAccessToken( $code );

        Yii::$app->getResponse()->redirect( yii::$app->session['ret_url'] );
    }
    
    public function actionSharePage()
    {
        //判断链接有效性
        $proxyId =  Yii::$app->request->get('id');
        $proxyObj = MgUsers::findOne( ['id'=>$proxyId,'is_bd'=> MgUsers::IS_BD ] );
        if( !$proxyObj )
            $this->_404('代理链接错误');
        $gObj = MgGames::findOne(['id'=>yii::$app->request->get('gid', 1)]);
        if( !$gObj )
            $this->_404('游戏信息错误');
        //判断用户是否关注
        $uObj = MgUsers::findOne([
            'open_id'=>$this->open_id,
            'status'=>MgUsers::IS_SUBSCRIPT,
            //'is_bd'=> MgUsers::IS_BD
        ]);
        if( $uObj && ($uObj->is_bd != MgUsers::IS_BD) )
            $this->_404('您还不是推广员请联系您的代理设置');
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
    
    /**
     * 代理分享链接
     * @return string
     */
    public function actionShareProxy()
    {
        $proxyObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( !$proxyObj )
            $this->_404('用户信息错误');
        //判断是否满足推广
        $isProxyBd = false;
        $shareUrl = yii::$app->request->url;
        $imageUrl = '';
        if( $proxyObj->rebate_ratio >= 35 ){
            $isProxyBd = true;
            $shareUrl = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/default/show-proxy-link','id'=>$proxyObj->id ] );
            $imageUrl = Yii::$app->urlManager->createAbsoluteUrl(['/Wechat/api/get-qr-pic','pid'=>$proxyObj->id ] );
        }
        
        return $this->renderPartial('share_proxy',[
            'uObj'=> $proxyObj,
            'shareLink'=> $shareUrl,
            'imageUrl' =>$imageUrl,
            'isProxyBd'=> $isProxyBd
        ]);
    }
    
    /**
     * 绑定代理关系确认页
     */
    public function actionShowProxyLink(){
        if( !($uid = (int)yii::$app->request->get('id')) )
            $this->_404('用户信息错误');
        $proxyObj = MgUsers::find()->where(['id'=>$uid,'is_bd'=>MgUsers::IS_BD])->andWhere(['>=','rebate_ratio', 35])->one();
        if( !$proxyObj )
            $this->_404('代理信息错误或代理连接失效');
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        return $this->renderPartial('show-proxy-link',[
            'uObj' => $uObj,
            'user_data'=> $this->user_data,
            'proxyObj'=> $proxyObj
        ]);
    }
    
    /**
     * 关系绑定页
     */
    public function actionBindProxy(){
        
        if( !($uid = (int)yii::$app->request->get('id')) )
            $this->_404('用户信息错误');
        $proxy = MgUsers::find()->where(['id'=>$uid,'is_bd'=>MgUsers::IS_BD])->andWhere(['>=','rebate_ratio', 35])->one();
        if( !$proxy )
            $this->_404('代理信息错误或代理连接失效');
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( !$uObj ){
            try{
                $ret = UserService::getInstance()->createUser([
                    'open_id' =>  $this->user_data['openid'],
                    'union_id' =>  $this->user_data['unionid'],
                    'nickname'=> $this->user_data['nickname'],
                    'user_logo'=>$this->user_data['headimgurl'],
                ]);
                $uObj = $ret['data']['user'];
            }catch (\Exception $e ){
                yii::error($e->getMessage());
                $this->_404('用户信息错误');
            }
        }
        if( $uObj->is_bd == MgUsers::IS_BD )
            $this->_404('您已经是代理，无法关注');
        $ret = UserService::getInstance()->bindProxyRel( $proxy , $uObj );
        if( !$ret['isOk'] ){
            yii::error( "绑定代理错误: ".$ret['msg']);
            $this->_404('绑定信息失败，请稍后再试');
        }
        //发送绑定 成功通知
        $ret = WeChatService::getIns()->sendCsMsg([
            'touser'=> $proxy->open_id ,
            'msgtype'=>'text',
            'text'=>[
                'content'=> "恭喜，您已成功邀请 {$uObj->nickname} 成为您的推广员。",
            ]
        ]); 
        return $this->renderPartial('proxy-bind-success',[
            'uObj' => $uObj,
            'proxyObj'=> $proxy
        ]);
    }
    
    /**
     * 游戏下载页
     */
    public function actionGamePage()
    {
        $gObj = MgGames::findOne(['id'=>yii::$app->request->get('id', 1)]);
        if( !$gObj )
            $this->_404('信息错误');
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
        $this->title = '首页';
        //判断用户是否为mg用户   
        $mgInfo = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $mgInfo == null ){
            $this->_404('访问受限');
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
            $this->_404('访问受限 ');
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
            $this->_404('访问受限 ');
        }
        if( !($friend_id = yii::$app->request->get('id', 0) )  )
            $this->_404('用户id为空');
        $friendObj = MgUsers::findOne( ['id'=>$friend_id] );
        if( !$friendObj )
            $this->_404('好友不存在');
        //判断是否为自己的好友
        $rels = explode("-",$friendObj->user_rels);
        $pid = array_pop( $rels );
        if( $pid != $mgInfo->id )
            $this->_404('好友不存在');
        return $this->render('friend_info', [
            'fObj'=> $friendObj,
        ]);
    }
    
    //我的下级代理列表
    public function actionMyProxy()
    {
        $this->title = '我的代理';
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $uObj == null ){
            $this->_404('访问受限 ');
        }
        $ids = [];
        $subObjs = MgUserProxyRel::findAll( ['user_id'=>$uObj->id] );
        foreach( $subObjs as $subObj){
            $ids[] = $subObj->sub_user_id;
        }
        $subs = MgUsers::findAll( ['id'=>$ids ] );
        return $this->render('my_proxy', [
            'subs'=> $subs,
        ]);
    }
    
    //我的下级代理详情
    public function actionProxyInfo()
    {
        $this->title = '我的下级代理';
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $uObj == null ){
            $this->_404('访问受限 ');
        }
        if( !($proxy_id = yii::$app->request->get('id', 0) )  )
            $this->_404('用户id为空');
        $proxyObj = MgUsers::findOne( ['id'=>$proxy_id] );
        if( !$proxyObj )
            $this->_404('信息不存在');
        //判断是否为自己的好友
        $rels = explode("-",$proxyObj->user_proxy_rels);
        $pid = array_pop( $rels );
        if( $pid != $uObj->id )
            $this->_404('好友不存在');
        //获取下级代理数
        $proxyNum = MgUserProxyRel::find()->andWhere(['user_id'=>$proxyObj->id])->count('id');
        $playerNum = MgUserRel::find()->andWhere(['user_id'=>$proxyObj->id])->count('id');
        //总累计金额
        $uAccount = MgUserAccount::findOne(['user_id'=>$proxyObj->id]);
        return $this->render('proxy_info', [
            'fObj'=> $proxyObj,
            'proxyObj' => $uObj,
            'proxyNum' => $proxyNum,
            'playerNum' =>$playerNum,
            'uAccount' => $uAccount
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
        $limit = 5;
        //查看是否有提现记录 第一次提现上线为1元
        $rebateObj = MgRebateList::findOne(['user_id'=>$uObj->id]);
        if( !$rebateObj )
            $limit = 1;
        return $this->render('my_wallet',[
            'account' => $uaObj,
            'limit' => $limit
        ]);
    }
    
    //输入提现金额 input-money
    public function actionInputMoney(){
        
        $this->title="提取返现";
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        $uaObj = MgUserAccount::findOne(['user_id'=>$uObj->id]);
        //最少提现金额
        $limit = 5;
        return $this->render('input_money',[
            'account' => $uaObj,
            'limit' => $limit
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
            $this->_404('信息错误');
        
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
        //获取代理uid
        $pList = UserService::getInstance()->getSubProxy( $uObj );
        foreach ( $pList as $pObj ){
           $uids[] = $pObj->id;
        }
        $uids = array_unique( $uids );
        
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
    
    private function _404( $msg, $data =[] ){
        throw new HttpException(500, $msg);
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
    
    
    /**
     * 修改返利比例
     */
    public function actionChangeRatio(){
        $ratio = Yii::$app->request->get("ratio", 0 );
        $uObj = MgUsers::findOne(['open_id'=>$this->open_id]);
        if( $uObj == null ){
            $this->_404('访问受限 ');
        }
        if( !($proxy_id = yii::$app->request->get('pid', 0) )  )
            $this->_404('用户id为空');
        $pObj = MgUsers::findOne( ['id'=>$proxy_id] );
        if( !$pObj )
            $this->_404('信息不存在');
        if( $ratio < 30 || $ratio > $uObj->rebate_ratio )
            $this->_404("返利比例错误");
        $ret = UserService::getInstance()->changeRatio( $pObj , $ratio );
        CommonResponse::end($ret);
    }
}
