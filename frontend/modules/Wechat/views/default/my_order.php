<div class="weui-flex" style="margin-bottom:60px; position: fixed;
    left: 0;
    right: 0;
    top: 0;
    z-index: 999; ">
    <!--
    <div class="weui-navbar" >
        <div class="weui-navbar__item weui-bar__item_on">我的订单</div>
         <div class="weui-navbar__item">待支付</div>
        <div class="weui-navbar__item">已取消</div> 
   </div>
   -->
</div>
<div class="weui-flex" style="/* margin-top:60px;*/margin-bottom:30px;  ">
    <div style="width: 100%;">
        <?php foreach ($order_list as $k =>$order ):?>
        <div class="weui-form-preview">
            <div class="weui-form-preview__hd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">付款金额</label>
                    <em class="weui-form-preview__value">¥<?php echo $order->order_num?></em>
                </div>
            </div>
            <div class="weui-form-preview__bd">
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">商品</label>
                    <span class="weui-form-preview__value"><?php echo "游戏砖石"?></span>
                </div>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">状态</label>
                    <span class="weui-form-preview__value">支付成功</span>
                </div>
                <?php if( !empty( $order->pay_sn ) ): ?>
                <div class="weui-form-preview__item">
                    <label class="weui-form-preview__label">支付信息</label>
                    <span class="weui-form-preview__value">流水号：<?php echo $order->pay_sn; ?>   时间：<?php echo $order->update_time;?></span>
                </div>
                <?php endif;?>
            </div>
<!--             <div class="weui-form-preview__ft">
                <a class="weui-form-preview__btn weui-form-preview__btn_primary" href="javascript:">操作</a>
            </div> -->
        </div>
       <?php endforeach;?>
    </div>
</div>