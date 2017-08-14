<div class="page msg_success js_show">
    <div style="height:40px;"></div>
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <p style="font-size: 15px;">我的余额</p>
            <h2 class="weui-msg__title" style="font-size: 25px;">¥<?php echo isset( $account->free_balance ) ? $account->free_balance : 0; ?></h2>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <?php if( isset( $account->free_balance ) && !empty( $account->free_balance ) ):?>
                <a href="javascript:void(0);" class="weui-btn weui-btn_primary _rebate">提现</a>
                <br>   <!--   class="weui-btn weui-btn_default" -->
                <?php endif;?>
                <a  href="/Wechat/default/my-rebates">查看记录</a>
            </p>
        </div>
    </div>
</div>
<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
</style>
<script src="/js/base.js"></script>
<script>
//提现操作
$("._rebate").click(function(){
	var limit = 200;
	var money = parseInt( $(".weui-msg__title").html().substring( 1 ) );
	if( money < limit ){
		mgUI.msg('余额大于'+limit+'以上才可提现');
		return false;
	}
	mgUI.startload('请求处理中');
	$.ajax({
		url:'/Wechat/order/get-rebate',
		success:function( data ){
			var d = eval("("+data+")");
			if( !d.isOk ){
				mgUI.msg( d.msg );
				return false;
			}
			mgUI.msg( d.msg, function(){
				location.href="/Wechat/default/my-wallet";
			});
			//mgUI.endload();
		}
	});
});
</script>

