<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\service\weixin\WeChatService;
use common\service\order\OrderService;
use common\models\MgOrderList;
use common\components\order\BalanceBehavior;
use common\service\users\UserService;
use common\models\MgUsers;

/**
 * Default controller for the `Game` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
            $msg = <<<EOF
                               客官，终于等到您了，欢迎来到人人麻将！
                1、	下载游戏请<a href="http://wx.menguanol.net/Wechat/default/game-page">点击</a>
                2、	提交BUG请回复咨询客服
                3、	游戏充值<a href="http://wx.menguanol.net/Wechat/default/my-index">点击</a>
                4、	进入我的后台 <a href="http://wx.menguanol.net/Wechat/default/my-index">点击</a>
                5、	立刻生成自己<a href="http://wx.menguanol.net/Wechat/default/share-page">专属二维码</a>，推广下线。
                                我们正在招兵买马，全国招收代理：代理可享受以下政策
                1、	可查看好友账单明细与提现等操作。
                2、	生成自己专属二维码，方便推广。
                3、	成功绑定下级，享受名下玩家消费返利。
                4、	免费培训，帮助代理躺着赚钱。
EOF;
       // var_dump(yii::$app->request->url);
    }
    
    
}
