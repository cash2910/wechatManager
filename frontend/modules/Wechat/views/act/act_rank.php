<div class="page__category js_categoryInner" data-height="224" style="">
    <div class="weui-cells page__category-content">
    
        <?php foreach ($data as $k => $info):?>
        <a class="weui-cell weui-cell_access js_item" data-id="button" href="javascript:;">
            <div class="weui-cell__bd">
                <p><?php echo $uMap[$info[2]]->nickname;?>  当前活跃用户数：<?php echo $info[1];?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<style>
.weui-cell__bd p{
	text-align: center;
}
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A:active { TEXT-DECORATION: none}
A:VISITED{color:black;}
A{
	color:black;
}
</style>