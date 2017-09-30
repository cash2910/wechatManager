<?php if( !empty( $data ) ):?>
    <div class="page__category js_categoryInner" data-height="224" style="">
        <div class="weui-cells page__category-content">
        
            <?php foreach ($data as $k => $info):?>
            <a class="weui-cell weui-cell_access js_item" data-id="button" href="javascript:;">
                <div class="weui-cell__bd">
                    <p><?php echo $uMap[$info[2]]->nickname;?>  活跃用户数：<?php echo $info[1];?></p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php else:?>
    <div class="weui-cell" style="height: 100%;">
    <div class="weui-loadmore weui-loadmore_line">
        <span class="weui-loadmore__tips">暂无信息</span>
    </div>
    </div>
<?php endif;?>
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