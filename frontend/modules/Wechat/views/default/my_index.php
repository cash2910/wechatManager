<div class="weui-flex">
    <div class="weui-flex__item">
        <div class="icon-box" style="padding:30px;">
            <img style="float:left;" src="http://pic.nen.com.cn/600/15/97/18/15971842_791759.jpg" width="80" height="80"/>
            <div style="float:left;  margin-left:15px;">
                <h4 ><?=$user['nickname'] ?></h4>
                <p class="icon-box__desc">加入时间：<?=date("Y-m-d",$user['register_time']) ?></p>
            </div>
        </div>
    </div>
</div>
<div class="weui-flex">
    <div class="weui-flex__item">
        <div class="page__category js_categoryInner" data-height="495" style="">
            <div class="weui-cells page__category-content">
                <a class="weui-cell weui-cell_access js_item" data-id="article" href="javascript:;">
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
                 <a class="weui-cell weui-cell_access js_item" data-id="badge" href="javascript:;">
                    <div class="weui-cell__bd">
                        <p>提现管理</p>
                    </div>
                    <div class="weui-cell__ft"></div>
                </a>
            </div>
        </div>
    </div>
</div>