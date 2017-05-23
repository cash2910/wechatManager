<?php
namespace service\weixin;

class WeChatReqFactory{
    
    final static  $MST_TPL = [
        'text'=>[
            'Content'
        ],
        'image'=>[
            'PicUrl','MediaId'
        ],
        'voice'=>[
            'MediaId','Format'
        ],
        'video'=>[
            'MediaId','ThumbMediaId'
        ],
        'shortvideo'=>[
            'MediaId','ThumbMediaId'
        ],
        'location'=>[
            'Location_X','Location_Y','Scale','Label'
        ],
        'link'=>[
            'Title','Description','Url'
        ],
        'event'=>[
            'Event','MediaId'
        ]
    ];
    
}

?>