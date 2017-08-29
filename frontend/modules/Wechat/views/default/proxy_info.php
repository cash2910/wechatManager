<?php 
use common\helper\StringHelp;
?>
<div class="logo-box" style="
    padding: 40px;
    margin-bottom: 100px;
">
    <div style="float:left"><img style=" border-radius: 1.0rem;" src="<?= $fObj['user_logo'] ?>" width="100"> </div>
    <div style="float:left;    margin-left: 30px;">
        <h3 ><?= StringHelp::truncateUtf8String($fObj['nickname'], 6); ?></h3>
        <p  >加入时间：<?= date("Y-m-d",$fObj['register_time']) ?></p>
    </div>
</div>
<div class="weui-cells weui-cells_form" style="margin-bottom: 20px;">
        <input type="hidden" id="pid" value="<?= $fObj['id'] ?>">
        <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd"><label class="weui-label">设置为推广员</label></div>
            <div class="weui-cell__ft">
                <input class="weui-switch" type="checkbox" checked disabled="disabled">
            </div>
        </div>
        
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">分成比例</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                <input class="weui-input" type="number" pattern="[0-9]*"  id ="rebate_ratio" name="rebate_ratio" value="<?= $fObj['rebate_ratio'] ?>" placeholder="请输入分成比例">%
            </div>
        </div>
        
        <article class="weui-article">
           <section>
                <section>
                    <h3>推广员制度：</h3>
                    <br>
                    <p>1、玩家与代理的关系终身标记</p>
                    <p>2、可邀请玩家成为自己的代理或推广员</p>
                    <p>3、即时充返制度</p>
                    <p>4、返利比例可调整</p>
                    <p>5、"首问负责制"原则</p>
                </section>
           </section>
        </article>
        
        <label for="weuiAgree" class="weui-agree">
            <input id="weuiAgree" type="checkbox"  checked  class="weui-agree__checkbox">
            <span class="weui-agree__text"> 阅读并同意上述《相关条款》
            </span>
        </label>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:;" id="showTooltips">确定</a>
        </div>
</div>
<div >
    
</div>
<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A{ TEXT-DECORATION: none; color:black}
</style>
<script src="/js/base.js"></script>
<script>
$(function(){
    $('#showTooltips').on('click', function(){
        //$('.page.cell').removeClass('slideIn');
    	var rebateVal = $("#rebate_ratio").val();
    	var pid = $("#pid").val();
    	var max = '<?= $proxyObj->rebate_ratio; ?>';
        if(  rebateVal < 30 || rebateVal > max ){
        	mgUI.errorTip("可调整的代理返利比例范围为30%~"+parseInt(max)+"%", 4000);
        	$("#rebate_ratio").val("");
        	return false;
        }
		if( !$("#weuiAgree")[0].checked ){
        	mgUI.errorTip("请先阅读并同意相关条款", 4000);
        	return false;
        }

        $.ajax({
			url:'/Wechat/default/change-ratio',
			data:{
				pid:pid,
				ratio:rebateVal
		    },
			success:function( res ){
				var data = eval("("+res+")");
				mgUI.msg( data.msg  );
		    }
        });
    });
});
</script>