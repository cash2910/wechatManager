<?php
use common\models\MgUserAccountLog;
use yii\helpers\ArrayHelper;
?>
<div style="padding: 25px;">
    <h3 class="page__title">   好友充值总额：<span style="color: limegreen;"><?php echo $sum;?></span></h3>
    <div class="weui-cells">
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>直接玩家</p>
            </div>
            <div class="weui-cell__ft"><span style="color: limegreen;"><?php echo $info['subUser'];?></span></div>
        </div>
       <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>直接下级代理</p>
            </div>
            <div class="weui-cell__ft"><span style="color: limegreen;"><?php echo $info['subBd'];?></span></div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>今日直接玩家充值</p>
            </div>
            <div class="weui-cell__ft"><span style="color: limegreen;"><?php echo $info['subUserCharge'];?>￥</span></div>
        </div>
        <div class="weui-cell">
            <div class="weui-cell__bd">
                <p>今日代理玩家充值</p>
            </div>
            <div class="weui-cell__ft"><span style="color: limegreen;"><?php echo $info['subBdCharge'];?>￥</span></div>
        </div>
    </div>
</div>
<div class="rebates_list" >
    <?php if($order_list ): ?>
        <?php foreach( $order_list as $order ):?>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title _desc" > 好友 : <?php echo ArrayHelper::getValue($user_map, $order->user_id)['nickname'];?></h4>
                <h3 class="weui-media-box__title" ><?php echo $order->order_desc;?></h3>
                <p class="weui-media-box__desc"><?php echo $order->add_time?></p>
            </div>
            <div class="weui-media-box__bd" >
                <p style="text-align: right;font-size: 23px; color: limegreen;"> <?php echo $order->order_num?>￥</p>
            </div>
        </a>
        <?php endforeach;?>
    <?php else:?>
        <div class="weui-cell" style="height: 100%;">
        <div class="weui-loadmore weui-loadmore_line">
            <span class="weui-loadmore__tips">暂无信息</span>
        </div>
        </div>
    <?php endif;?>
</div>
<style>
._desc{
	font-weight: bold;font-size: 15px;
}
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A:active { TEXT-DECORATION: none}
</style>