<div class="weui-flex" style="position: absolute;
    top: 0;
    background-color: #f8f8f8;
    bottom: 0;
    left: 0;
    right: 0;">
    <div class="weui-flex__item" style="margin:20px 20px;">
        <div class="weui-panel__hd" >
            <div style="color: #333;">充值游戏</div>
        </div>
        <div class="weui-cells__tips" style="margin-top: 10px;">充值金额</div>
        <div class="weui-cell weui-cells_form">
             <div class="weui-cell__hd"> ￥</div>
             <div class="weui-cell__bd" style="font-size: 36px;"> <input class="weui-input" id="_total" type="number" pattern="[0-9]*" placeholder="" autofocus /> </div>
        </div>
        <div  class="weui-flex__hd">
            <div class="">
                <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">充值</a>
            </div>
        </div>
    </div>
</div>
<script>
$("#_total").focus();
</script>
<style>
.weui-cell:before {
	    border-top:0px;
}
</style>