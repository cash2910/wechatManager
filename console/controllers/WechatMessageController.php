<?php
namespace console\controllers;

use yii;
use yii\console\Controller;
use common\models\WechatMessage;
use common\service\weixin\WeChatMsgService;
use common\service\weixin\WeChatService;
use common\models\MgUsers;
use yii\helpers\ArrayHelper;

class WechatMessageController extends Controller{
    
    /**
     * 微信通知用户
     */
    public function actionNotify(){
        
        $dateTime = date('Y-m-d H:i:s');
        $msgs = WechatMessage::find()->where(['status'=>WechatMessage::STATUS_WAIT])->andWhere(['<=','send_time',$dateTime])->all();
        yii::error("{$dateTime}通知执行开启：".$ret['msg']);
        foreach ( $msgs as $mObj ){
             $ret = $this->sendMsg( $mObj );    
             $mObj->status = WechatMessage::STATUS_SUCCESS;
             $mObj->save();
             yii::error("通知{$mObj->id}信息发送状态：".$ret['msg']);
        }
        yii::error("{$dateTime}通知执行完毕：".$ret['msg']);
    }
    
    private function sendMsg( WechatMessage $mObj ){
        $ret = ['isOk'=>1, 'msg'=> '发送成功!' ];        
        try {
            $msgService = WeChatMsgService::getInstance(WeChatService::getIns());
            $dateTime = date('Y-m-d H:i:s');
            switch ($mObj->type){
                case WechatMessage::TYPE_ONE:
                    //获取用户信息
                    $u = MgUsers::findOne(['open_id'=>$mObj->open_id]);
                    $users = [$u];
                    break;
                case WechatMessage::TYPE_ALL:
                    $users = MgUsers::findAll(['status'=>MgUsers::IS_SUBSCRIPT]);
                    break;
                case WechatMessage::TYPE_BD:
                    $users = MgUsers::findAll(['is_bd'=>MgUsers::IS_BD]);
                    break;
                default:
                    break;
            }
            foreach ($users as $user){
                $ret = $msgService->notify([
                    'touser'=>$user->open_id,
                    // 'url'=>'',
                    'data'=>[
                        'first'=>[
                            'value'=>ArrayHelper::getValue($mObj, 'desc'),
                            'color'=>'#173177'
                        ],
                        'keyword1'=>[
                            'value'=>'更新通知',
                            'color'=>'#173177'
                        ],
                        'keyword2'=>[
                            'value'=>$dateTime,
                            'color'=>'#173177'
                        ],
                        'remark'=>[
                            'value'=>ArrayHelper::getValue($mObj, 'content'),
                            'color'=>'#173177'
                        ]
                    ]
                ]);
            }
            
        } catch (\Exception $e) {
            $ret['isOk'] = 0;
            $ret['msg'] = $e->getMessage();
        }
        return $ret;
    }
    
}

?>