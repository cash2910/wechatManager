<?php
return [
    'company_name'=>'MG网络',
    'game_opt'=>[
        '100001'=>'用户登录',//   data 为空
        '100002'=>'用户退出',//(当服务端与游戏客户端连接断开时事件)   data 为空
        '100003'=>'用户消费',//data: {  Total：”200”  //金额  Product_id: “” //道具id  Product_desc:”” //道具内容 }
        '100004'=>'建立房间',// data:{  Room_id:111 //房间id }
        '100005'=>'退出房间',// 退出前在房间中的比赛情况 data:{  Room_id:111   Win:1,   Lost: 2 }
        '100006'=>'进入游戏',// 不需要提供 union_id
    ]
];
