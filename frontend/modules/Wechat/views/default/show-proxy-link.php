<?php 
use common\models\MgUsers;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>确认绑定</title>
    <link rel="stylesheet" href="/css/weui/weui.min.css">
    <script type="text/javascript" src="/js/jquery-2.2.3.min.js"></script>
</head>
<body>
<?php if( !$uObj || $uObj->is_bd != MgUsers::IS_BD ): ?>
<div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">确认邀请</h2>
            <!--  <p class="weui-msg__desc">成为代理，可根据实际需要安排，如果换行则不超过规定长度，居中展现<a href="javascript:void(0);">文字链接</a></p> -->
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="/Wechat/default/bind-proxy?id=<?= $proxyObj->id ?>" class="weui-btn weui-btn_primary">确认</a>
            </p>
        </div>
</div>
<?php else:?>
<div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-success weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title">您已经是代理了</h2>
            <p class="weui-msg__desc">您已经是代理了,无法再次绑定代理关系</p>
        </div>
        <div class="weui-msg__opr-area">
            <p class="weui-btn-area">
                <a href="/Wechat/default/share-page?id=<?= $uObj->id ?>" class="weui-btn weui-btn_primary">去邀请玩家</a>
            </p>
        </div>
</div>
<?php endif;?>
</body>
</html>