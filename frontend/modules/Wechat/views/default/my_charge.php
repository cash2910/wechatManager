<div  style="position: absolute;
    top: 0;
    background-color: #f8f8f8;
    bottom: 0;
    padding: 0 15px;
    left: 0;
    right: 0;">
    <div class="weui-flex" style="margin-top: 5px;" >
         <h4 class="title" style="color: #333;" >充值游戏</h4>
    </div>  
    <div class="weui-flex">
        <div class="weui-flex__item" >
           <div class="weui-flex">
               <div class="weui-cells__tips" style="margin-top: 10px; margin-bottom:10px;">充值数量</div>
           </div>
           <div class="weui-flex game_goods" >
                <?php foreach($goods as $id => $good):?>
                <!--  weui-btn_primary  -->
               <a href="javascript:;" class="weui-btn weui-btn_mini " ><?php echo $good->title?></a>
                <a href="javascript:;" class="weui-btn weui-btn_mini " ><?php echo $good->title?></a>
                <?php endforeach;?>
            </div>
            <div class="weui-flex" style="margin-top: 10px;">
                 <p ><span class="sp_total">50.6</span>元<span class="sp_discount">（95折）</span></p>
            </div>
        </div>
    </div>
     <div class="weui-flex">
        <div class="weui-flex__item">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="weixin_pay">充值</a>
        </div>
     </div>
</div>
<script>
$(function(){
	$(".game_goods .weui-flex__item").click(function(){
		$(this).find("a").addClass("weui-btn_primary");
		$(this).siblings().each(function(){
			$(this).find("a").removeClass("weui-btn_primary");
	    })
		
	    
	});
});

</script>
<style>
.weui-flex .weui-flex__item {
	margin: 0.1em;
}
.weui-flex .weui-flex__item  .weui-btn_mini{
	font-size: 17px;
	color: #000;
    background-color: #f8f8f8;
}

.weui-flex .weui-flex__item  .weui-btn_primary{
	background-color: #1aad19;
	color: #fff;
}
.sp_total{
	font-size: 25px;
    margin-right: 3px;
    color: coral;
}
.sp_discount{
	font-size: 10px;
}
</style>