<?php

namespace backend\modules\Wechat;

/**
 * WeChat module definition class
 */
class WechatModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\Wechat\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public function getMenu(){
        return [
             'items' => [
                   ['label'=>'微信用户', 'items'=>[
                       ['label'=>'用户管理','url' => ['/Wechat/wechat-user'], 'active' => 0 ],
                       ['label'=>'标签管理','url' => ['/Wechat/tag'], 'active' => 0 ]
                   ]],
                   ['label'=>'菜单管理','url' => ['/Wechat/menu'], 'active' => 1 ],
                   ['label'=>'用户管理','url' => ['/Wechat/mg-user'], 'active' => 0 ],
                   ['label'=>'客服管理','url' => ['/Wechat/cs'], 'active' => 0 ],
                   ['label'=>'后台用户管理','url' => ['/Wechat/user'], 'active' => 0 ],
              ]
        ];
    }
}
