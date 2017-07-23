<?php
use common\models\MgUserAccountLog;
?>
<div class="rebates_list" >
    <?php if($account_list ): ?>
        <?php foreach( $account_list as $log ):?>
        <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
            <div class="weui-media-box__bd">
                <h4 class="weui-media-box__title" style="font-weight: bold;font-size: 15px;"><?php echo MgUserAccountLog::$msg[$log->c_type];?></h4>
                <p class="weui-media-box__desc"><?php echo $log->add_time?></p>
            </div>
            <div class="weui-media-box__bd" >
                <?php $color = $log->c_type == MgUserAccountLog::INCOME ? 'limegreen': 'red' ?>
                <?php $append = $log->c_type == MgUserAccountLog::INCOME ? '+': '-' ?>
                <p style="text-align: right;font-size: 23px; color: <?php echo $color; ?>;"> <?php echo $append.$log->num?></p>
            </div>
        </a>
        <?php endforeach;?>
    
    <?php else:?>
        <div class="weui-cell" style="height: 100%;">
        <div class="weui-loadmore weui-loadmore_line">
            <span class="weui-loadmore__tips">暂无信息</span>
        </div>
        </div>
    <?php endif;?>
        
</div>
<div class="detail" style="display:none" >
    <div class="weui-form-preview">
        <div class="weui-form-preview__hd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">入账金额</label>
                <em class="weui-form-preview__value" style="font-size: 23px;color: limegreen;">¥240.00</em>
            </div>
        </div>
        <div class="weui-form-preview__bd">
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">类型</label>
                <span class="weui-form-preview__value">入账</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">时间</label>
                <span class="weui-form-preview__value">2017-06-07 08:56:32</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">交易号</label>
                <span class="weui-form-preview__value">1000313164645645697966663321313</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">剩余零钱</label>
                <span class="weui-form-preview__value">327.65</span>
            </div>
            <div class="weui-form-preview__item">
                <label class="weui-form-preview__label">备注</label>
                <span class="weui-form-preview__value">用户返利</span>
            </div>
        </div>
        <div class="weui-form-preview__ft">
            <a class="weui-form-preview__btn weui-form-preview__btn_primary _back" href="javascript:" >返回</a>
        </div>
    </div>
</div>
<script>
$(function(){
	$(".rebates_list a").click(function(){
		//$(".rebates_list").hide();
		//$(".detail").show();
	});
	$("._back").click(function(){
		//$(".detail").hide();
		//$(".rebates_list").show();
	});
});
</script>