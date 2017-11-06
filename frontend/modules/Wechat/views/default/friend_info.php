<?php 
use common\helper\StringHelp;
use common\models\MgUsers;
use yii\helpers\ArrayHelper;
?>
<div class="logo-box" style=" padding: 40px; margin-bottom: 100px;">
    <div style="float:left">
    <img style=" border-radius: 1.0rem;" src="<?= $fObj['user_logo'] ?>" width="100">
    </div>
    <div style="float:left;    margin-left: 30px;">
        <h3 ><?= StringHelp::truncateUtf8String($fObj['nickname'], 6); ?></h3>
        <?php if( $fObj->user_role != MgUsers::PLAYER_USER): ?>
        <p><?= MgUsers::$role_desc[$fObj->user_role]; ?></p>
        <?php endif;?>
        <p  >加入时间：<?= date("Y-m-d",$fObj['register_time']) ?></p>
    </div>
</div>

<div class="weui-cells weui-cells_form" style="margin-bottom: 20px;">
<?php 
    switch( $uObj->user_role ):
        case MgUsers::MANAGER_USER:
?>
        <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd"><label class="weui-label">设置为管理员</label></div>
            <div class="weui-cell__ft">
                <input class="weui-switch" type="checkbox" <?php echo ( $fObj->user_role == MgUsers::MANAGER_USER ) ? "checked onclick='return false;'" :"";?> id="user_role" name="role" value="1">
            </div>
        </div>
        <div class="weui-cells__title" style="display: none; color:red; margin-top: 0px;" id="warning_desc">一旦改为管理员将无法成为推广员</div>
        <?php if( $fObj->user_role == MgUsers::BD_USER): ?>
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">分成比例</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                <input class="weui-input" type="number" pattern="[0-9]*" id="ratio"  value="<?php echo (int)$fObj->rebate_ratio;?>" placeholder="请输入分成比例">%
            </div>
        </div>
        <div class="weui-cells__title" style="display: none; color:red; margin-top: 0px;" id="rebate_warning_desc">目前可调整的返利范围是<?php echo $fObj->rebate_ratio;?>%~<?php echo $uObj->rebate_ratio;?>%</div>
        <?php endif;?>
        
        <label for="weuiAgree" class="weui-agree">
            <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox">
            <span class="weui-agree__text">我已经了解该比例一旦调整后，仅支持向上调整，无法向下调整。 </span>
        </label>
        
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
        </div>
<?php 
        break;
        case MgUsers::BD_USER:
?>
        <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd"><label class="weui-label">设置为推广员</label></div>
            <div class="weui-cell__ft">
                <input class="weui-switch" type="checkbox" <?php echo ( $fObj->user_role == MgUsers::BD_USER ) ? "checked onclick='return false;'" :"";?> id="user_role" name="role" value="2">
            </div>
        </div>
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">分成比例</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                <input class="weui-input" type="number" pattern="[0-9]*" id="ratio"  value="<?php echo (int)$fObj->rebate_ratio;?>" placeholder="请输入分成比例">%
            </div>
        </div>
        <div class="weui-cells__title" style="display: none; color:red; margin-top: 0px;" id="rebate_warning_desc">目前可调整的返利范围是<?php echo $fObj->rebate_ratio;?>%~<?php echo $uObj->rebate_ratio;?>%</div>
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">今日流水</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                <span class="num"><?php echo ArrayHelper::getValue( $rebate_info, 'today')?>￥</span>
            </div>
        </div>
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">7天流水</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                 <span class="num"><?php echo ArrayHelper::getValue( $rebate_info, '7day')?>￥</span>
            </div>
        </div>
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">30天流水</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                 <span class="num"><?php echo ArrayHelper::getValue( $rebate_info, '30day')?>￥</span>
            </div>
        </div>
        <label for="weuiAgree" class="weui-agree">
            <input id="weuiAgree" type="checkbox" class="weui-agree__checkbox">
            <span class="weui-agree__text">我已经了解该比例一旦调整后，仅支持向上调整，无法向下调整。 </span>
        </label>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
        </div>
<?php 
        break;
        default:break;
    endswitch;
?>
</div>

<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A:active { TEXT-DECORATION: none;}
A:VISITED{color:black;}
</style>
<script src="/js/base.js"></script>
<script>
$(function(){
	//若用户被修改为管理员，弹出提示信息
	$("#user_role").change(function(){
		 if( this.value != 1 )
			return ;
		 if( $(this).is(':checked') ){
			$("#warning_desc").show();
		 }else{
			 $("#warning_desc").hide();
	     }
	});
	//修改返利比例设置
	$("#ratio").on('focus',function(){
		$("#rebate_warning_desc").show();
    });
    $('#showTooltips').on('click', function(){
        //检测是否确认条款
		if( !$("#weuiAgree")[0].checked ){
        	mgUI.errorTip( '请先确认相关信息' );
			return false;
		}
        var ratio = $("#ratio").val();
        var max_ratio = '<?php echo $uObj->rebate_ratio;?>';
        var min_ratio = '<?php echo $fObj->rebate_ratio;?>';
        var fid = '<?php echo $fObj->id ?>';
        var role = $("#user_role")[0].checked ? $("#user_role").val() : "";
        if( ratio > max_ratio || ratio < min_ratio ){
        	mgUI.errorTip( '可调整的返利范围是'+min_ratio+'%~'+max_ratio+'%' );
			return false;
        }

        if( !fid ){
        	mgUI.msg( '用户信息错误' );
			return false;
        }
    	mgUI.startload('请求处理中');
    	$.ajax({
    		url:'/Wechat/api/upgrade-level?fid='+fid+"&role="+role+"&ratio="+ratio,
    		success:function( data ){
    			mgUI.endload();
    			var d = eval("("+data+")");
    			console.dir(d);
    			if( !d.isOk ){
    				mgUI.errorTip(  d.msg );
    				
    				return false;
    			}
    			mgUI.msg( d.msg, function(){
    				location.href = location.href;
    			});
    		}
    	});
        
    });
});
</script>