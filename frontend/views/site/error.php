<?php 
use yii\helpers\Html;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>操作失败</title>
    <link rel="stylesheet" href="/css/weui/weui.min.css">
</head>
<body>
<div class="page msg_warn js_show">
    <div class="weui-msg">
        <div class="weui-msg__icon-area"><i class="weui-icon-warn weui-icon_msg"></i></div>
        <div class="weui-msg__text-area">
            <h2 class="weui-msg__title"><?= nl2br(Html::encode($message)) ?></h2>
            <p class="weui-msg__desc"> </p>
        </div>
    </div>
</div>
</body>
</html>