<?php
use common\models\MgUserAccountLog;
?>
<div style="padding: 25px;">
    <h3 class="page__title">好友充值总额：<?php echo $sum;?></h3>
</div>
<div class="rebates_list" >
    <?php if($order_list ): ?>
        <?php foreach( $order_list as $order ):?>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title" style="font-weight: bold;font-size: 15px;"><?php echo $user_map[$order->user_id][0]->nickname.":".$order->order_desc;?></h4>
                <p class="weui-media-box__desc"><?php echo $order->add_time?></p>
            </div>
            <div class="weui-media-box__bd" >
                <p style="text-align: right;font-size: 23px; "> <?php echo $order->order_num?></p>
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