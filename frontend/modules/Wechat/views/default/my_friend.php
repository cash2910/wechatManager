<div style="width: 100%;">
    <div class="weui-cells">
        <?php if( !empty( $subs ) ):?>
            <?php foreach ($subs as $sub):?>
            <div class="weui-cell">
                <div class="weui-cell__hd" style="position: relative;margin-right: 10px;">
                    <img src="<?=$sub['user_logo'] ?>" style="width: 50px;display: block">
                   <!--  <span class="weui-badge" style="position: absolute;top: -.4em;right: -.4em;">8</span>  -->
                </div>
                <div class="weui-cell__bd">
                    <p><?=$sub['nickname'] ?></p>
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
</div>