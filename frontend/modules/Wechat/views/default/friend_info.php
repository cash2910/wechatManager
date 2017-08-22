<?php 
use common\helper\StringHelp;
?>
<div class="logo-box" style="
    padding: 40px;
    margin-bottom: 100px;
">
    <div style="float:left">
    <img style=" border-radius: 1.0rem;" src="<?= $fObj['user_logo'] ?>" width="100">
    </div>
    <div style="float:left;    margin-left: 30px;">
        <h3 ><?= StringHelp::truncateUtf8String($fObj['nickname'], 6); ?></h3>
        <p  >加入时间：<?= date("Y-m-d",$fObj['register_time']) ?></p>
    </div>
</div>
<div class="weui-cells weui-cells_form" style="margin-bottom: 20px;">
        <div class="weui-cell weui-cell_switch">
            <div class="weui-cell__bd"><label class="weui-label">设置为推广员</label></div>
            <div class="weui-cell__ft">
                <input class="weui-switch" type="checkbox">
            </div>
        </div>
        
        <div class="weui-cell " >
            <div class="weui-cell__hd"><label class="weui-label">分成比例</label></div>
            <div class="weui-cell__bd" style="display: inline-flex;">
                <input class="weui-input" type="number" pattern="[0-9]\.*" placeholder="请输入分成比例">%
            </div>
        </div>
        
        <article class="weui-article">
           <section>
                <section>
                    <h3>推广员权限说明：</h3>
                    <p> 好友的推广权限，给予之后，就不能取消，只可以设定其返利比例为0 .</p>
                    <p>该好友 的好友的充值 按照下面返利比例 给予 他；</p>
                    <p>我 自己可以通过 这个充值 获得 XX%.</p>
                    <p>推荐根据好友的业绩来 来调整 这个返利比例设定。在下笔充值的时候按照新比例生效。</p>
                </section>
           </section>
        </article>
        
        <label for="weuiAgree" class="weui-agree">
            <input id="weuiAgree" type="checkbox"  checked  class="weui-agree__checkbox">
            <span class="weui-agree__text"> 阅读并同意上述《相关条款》
            </span>
        </label>
        <div class="weui-btn-area">
            <a class="weui-btn weui-btn_primary" href="javascript:" id="showTooltips">确定</a>
        </div>
</div>
<div >
    
</div>
<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A:active { TEXT-DECORATION: none}
</style>