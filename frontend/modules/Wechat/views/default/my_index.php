<div class="weui-flex">
    <div class="weui-flex__item">
        <div class="icon-box" style="padding:30px;">
            <img style="float:left; border-radius: 1.0rem;" src="<?=$user['user_logo'] ?>" width="80" height="80"/>
            <div style="float:left;  margin-left:15px;">
                <span class="nickname"><?=$user['nickname'] ?></span>
                <?php if( $user['is_bd'] ){ ?>
                <span class="type_wrp" style=" margin-left: 5px; ">  <a href="javascript:;" class="icon_proxy_label" >代理</a> </span>
                <?php }?>                                                                                                                                 
                <p class="icon-box__desc" style=" margin-top: 10px;">加入时间：<?=date("Y-m-d",$user['register_time']) ?></p>
            </div>
        </div>
    </div>
</div>
<div class="weui-flex">
    <div class="weui-flex__item">
        <div class="page__category js_categoryInner" data-height="495" style="">
            <div class="weui-cells page__category-content">
                 <a class="weui-cell weui-cell_access js_item" data-id="article" href="/Wechat/default/my-charge">
                    <div class="weui-cell__bd">
                        <p>立即充值</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access js_item" data-id="article" href="/Wechat/default/my-order">
                    <div class="weui-cell__bd">
                        <p>充值查询</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access js_item" data-id="badge" href="/Wechat/default/my-friend">
                    <div class="weui-cell__bd">
                        <p>我的好友</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                 <a class="weui-cell weui-cell_access js_item" data-id="badge" href="/Wechat/default/my-wallet">
                    <div class="weui-cell__bd">
                        <p>提现管理</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
                <a class="weui-cell weui-cell_access js_item" data-id="badge" href="/Wechat/default/friends-charge">
                    <div class="weui-cell__bd">
                        <p>好友充值</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
        </div>
    </div>
</div>
<style>
A:hover { FONT-WEIGHT: normal; TEXT-DECORATION: none}
A:active { TEXT-DECORATION: none}

.nickname{
	font-family: 微软雅黑;
    font-size: 21px;
}
.icon_proxy_label{
	background-color: #fbc15e;
	padding-left: 3px;
	padding-right: 3px;
    width: 48px;
    height: 21px;
    vertical-align: middle;
    line-height: 30px;
    overflow: hidden;
    font-size: 12px;
    border-radius: 0.2rem;
    color: white;
	font-family: 微软雅黑;
}
</style>