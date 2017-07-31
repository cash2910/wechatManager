<?php
use common\models\MgUserAccountLog;
?>
<div style="padding: 25px;">
    <h3 class="page__title">好友充值总额：<span style="color: #1ccc91;"><?php echo $sum;?></span></h3>
</div>
<div class="rebates_list" >
    <?php if($order_list ): ?>
        <?php foreach( $order_list as $order ):?>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title _desc" ><?php echo $user_map[$order->user_id][0]->nickname;?>:</h4>
                <h4 class="weui-media-box__title" ><?php echo $order->order_desc;?></h4>
                <p class="weui-media-box__desc"><?php echo $order->add_time?></p>
            </div>
            <div class="weui-media-box__bd" >
                <p style="text-align: right;font-size: 23px; color: #1ccc91;"> <?php echo $order->order_num?></p>
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
</style>