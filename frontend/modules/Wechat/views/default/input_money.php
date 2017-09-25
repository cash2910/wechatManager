<div class="weui-cells weui-cells_form">
    <div class="weui-cell">
        <div class="weui-cell__hd"><label class="weui-label">金额</label></div>
        <div class="weui-cell__bd">
            <input class="weui-input" type="number" pattern="[0-9]*" placeholder="最多可提现金额<?php echo $account->free_balance; ?>元">
        </div>
    </div>
 </div>
 <label  class="weui-agree" style="margin-top:5px;"> 
     <span style="color: #f15609;" >提现金额大于5元,可进行提现操作. 不满200元,需扣除5元手续费</span>
</label>
 <div class="weui-btn-area">
      <a class="weui-btn weui-btn_primary _rebate" href="javascript:" >下一步</a>
</div>

<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
</style>
<script src="/js/base.js"></script>
<script>
//提现操作
$("._rebate").click(function(){
	var limit = <?php echo $limit;?>;
	var money = parseInt( $(".weui-input").val() );
	if( money <= limit ){
		mgUI.msg('提现金额必须大于'+limit+'元');
		return false;
	}
	mgUI.startload('请求处理中');
	$.ajax({
		url:'/Wechat/order/get-rebate?num='+money,
		success:function( data ){
			mgUI.endload();
			var d = eval("("+data+")");
			if( !d.isOk ){
				mgUI.msg( d.msg );
				return false;
			}
			mgUI.msg( d.msg, function(){
				location.href="/Wechat/default/my-wallet";
			});
		}
	});
});
</script>