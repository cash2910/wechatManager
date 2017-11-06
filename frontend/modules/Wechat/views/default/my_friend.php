<?php 
use common\models\MgUsers;
?>
<div style="padding: 25px;">
    <h3 class="page__title">活跃用户数：<span style="color: limegreen;"><?php echo $score;?></span></h3>
</div>
<div class="weui-cells" style="margin-top: 20px;">
    <?php if( !empty( $subs ) ):?>
        <?php foreach ($subs as $sub):?>
        <div class="weui-cell">
            <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
               <a href="/Wechat/default/friend-info?id=<?=$sub['id'] ?>"><img src="<?=$sub['user_logo'] ?>" style="width: 50px;display: block"></a>
                 <span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;"><?php echo MgUsers::$role_desc[$sub['user_role']]?></span> 
            </div>
            <div class="weui-cell__bd">
                 <a href="/Wechat/default/friend-info?id=<?=$sub['id'] ?>"><p><?=$sub['nickname'] ?></p></a>
                <p style="font-size: 13px;color: #888888;">加入时间：<?=date("Y-m-d",$sub['register_time']) ?></p>
            </div>
        </div>
        <?php endforeach;?>
    <?php else:?>
    <div class="weui-cell" style="height: 100%;">
    <div class="weui-loadmore weui-loadmore_line">
        <span class="weui-loadmore__tips">暂无好友信息</span>
    </div>
    </div>
    <?php endif;?>
</div>
<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A:active { TEXT-DECORATION: none}
A:VISITED{color:black;}
A{
	color:black;
}
</style>