<div class="page msg_success js_show">
    <div style="height:40px;"></div>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <p style="font-size: 15px;">我的余额</p>
            <h2 class="weui-msg__title" style="font-size: 25px;">¥<?php echo isset( $account->free_balance ) ? $account->free_balance : 0; ?></h2>
        </div>
        <div class="weui-msg__opr-area">
            <?php if( isset( $account->free_balance ) && !empty( $account->free_balance ) ):?>
            <p class="weui-btn-area">
                <a href="javascript:history.back();" class="weui-btn weui-btn_primary">提现</a>
                <br>   <!--   class="weui-btn weui-btn_default" -->
                <a  href="/Wechat/default/my-rebates">查看记录</a>
            </p>
            <?php endif;?>
        </div>
    </div>
</div>