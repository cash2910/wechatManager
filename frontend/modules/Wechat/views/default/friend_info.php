<?php 
use common\helper\StringHelp;
use common\models\MgUsers;
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
        <?php if( $fObj->user_role == MgUsers::BD_USER): ?>
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">分成比例</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                <input class="weui-input" type="number" pattern="[0-9]*" id="ratio"  value="<?php echo (int)$fObj->rebate_ratio;?>" placeholder="请输入分成比例">%
            </div>
        </div>
        <?php endif;?>
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
    $('#showTooltips').on('click', function(){
        var fid = '<?php echo $fObj->id ?>';
        var role = $("#user_role")[0].checked ? $("#user_role").val() : "";
        var ratio = $("#ratio").val();
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