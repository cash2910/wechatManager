<?php 
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\MgGames;
?>
<div  style="position: absolute;
    top: 0;
    background-color: #f8f8f8;
    bottom: 0;
    padding: 0 15px;
    left: 0;
    right: 0;">
    <div class="weui-flex" style="margin-top: 5px;" >
         <div class="weui-cell weui-cell_select weui-cell_select-after">
            <div class="weui-cell__hd">
                <label for="" class="weui-label">选择游戏</label>
            </div>
            <div class="weui-cell__bd">
                <?php 
                    $data = MgGames::find()->all();
                    echo Html::dropDownList('select2', yii::$app->request->get('game_id', 1), ArrayHelper::map( $data,'id', 'title'), ['class' => 'weui-select game_sel', 'prompt' => '请选择游戏'] );
                ?>
            </div>
         </div>
    </div>
    <div class="weui-flex">
        <div class="weui-flex__item" >
           <div class="weui-flex">
               <div class="weui-cells__tips" style="margin-top: 10px; margin-bottom:10px;">充值数量</div>
           </div>
           <div class="flex-box game_goods" >
                <?php foreach($goods as $id => $good):?>
                <!--  weui-btn_primary  -->
                 <a href="javascript:;"  class="btn-group" data='<?php echo json_encode( $good->getAttributes()  ) ?>' ><?php echo $good->title?></a>
                <?php endforeach;?>
            </div>
            <div class="weui-flex" style="margin-top: 10px;">
                 <p ><span class="sp_total">50.6</span>元<span class="sp_discount">（95折）</span></p>
            </div>
        </div>
    </div>
     <div class="weui-flex">
        <div class="weui-flex__item">
            <a class="weui-btn weui-btn_primary" href="javascript:" style="cursor: pointer; " id="weixin_pay">充值</a>
        </div>
     </div>
</div>
<script>
var gid = 0 , gObj = null;
$(function(){
	//选择游戏
	$(".game_sel").change(function(){
		location.href = "/Wechat/default/my-charge?game_id="+$(this).val();
	});
	//选择商品
	$(".game_goods a").click(function(){
		$(this).addClass("active").siblings().removeClass("active");
		gObj = eval("("+ $(this).attr('data') +")");
		gid = gObj.id;
		//显示价格
		$(".sp_total").html( gObj.price );
		//计算折扣
		$(".sp_discount").html( "("+ parseInt(gObj.price/gObj.score*100) +"折)" );
	});
	//调用微信JS api 支付
	$("#weixin_pay").click(callpay);
});
function getOrder( data ){
	var oid = '';
	$.ajax({
		url:'/Wechat/order/get-order?gid='+gid,
		async:false,
		success:function( d ){
			var ret = eval( "("+d+")");
			if( !ret.isOk )
				throw ret.msg ;
			oid = d.data;
		}
    });
}

function jsApiCall()
{
	var oInfo = getOrder();
	if( !oInfo )
		throw '支付失败！';
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		JSON.stringify(oInfo),
		function(res){
			WeixinJSBridge.log(res.err_msg);
			alert(res.err_code+res.err_desc+res.err_msg);
		}
	);
}

function callpay()
{	
	try{
    	if (typeof WeixinJSBridge == "undefined"){
    	    if( document.addEventListener ){
    	        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
    	    }else if (document.attachEvent){
    	        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
    	        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
    	    }
    	}else{
    	    jsApiCall();
    	}
	}catch(  e ){
		console.dir( e );
	}
}
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


 *{
      border: 0; margin: 0; padding: 0;
    }
    .flex-box{
      display: flex;
      flex-wrap: wrap;
      padding: 10px;
      justify-content: space-between;
    }
   
    .btn-group{
      flex-basis: 23%;
      text-decoration: none;
      font-size: 14px;
      border-radius: 5px;
     -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
      text-align: center;
      text-decoration: none;
      color: #333;
      padding: 0.5em;
      border: 1px solid #eee;
      box-sizing: border-box;
      margin: 5px 0;
    }
    .btn-group.active{
      background-color: #1AAD19;
      color: #fff;
    }

</style>