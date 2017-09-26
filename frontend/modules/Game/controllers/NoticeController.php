<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\models\MgGameUseropt;
use common\service\weixin\WeChatService;
use common\models\MgUserRel;
use common\models\MgUsers;

/**
 * Default controller for the `Game` module
 */
class NoticeController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionUserOpt()
    {
        $ret = [
            'resultNo'=>0,
            'resultDesc'=>'请求成功！'
        ];
        yii::error("游戏参数：".json_encode( $_REQUEST ) );
        $model = new MgGameUseropt();
        $model->setAttributes( $_REQUEST );
        if (  !$model->save() ) {
            yii::error( "游戏参数保存失败：".json_encode( $model->getErrors() ,JSON_UNESCAPED_UNICODE ) );
            $ret['resultNo'] = 90000;
            $ret['resultDesc'] = json_encode( $model->getErrors() ,JSON_UNESCAPED_UNICODE );
        }else{
            $notice = $this->getMsg( $model );
            //提示用户
            if( !empty( $notice['openid'] ) ){
                $ret = WeChatService::getIns()->sendCsMsg([
                    'touser'=> $notice['openid'],
                    'msgtype'=>'text',
                    'text'=>[
                        'content'=>$notice['msg']
                    ]
                ]);
                yii::error( json_encode( $ret ) );
            }
        }
        echo json_encode( $ret );
    }
    
    /**
     * 获取用户提示信息
     * @param MgGameUseropt $optObj
     */
    private function getMsg( MgGameUseropt $optObj ){
        $ret = ['unid'=>'','msg'=>''];
        switch ( $optObj->opt_code ){
            case '100001':
                $uObj = MgUsers::findOne(['union_id'=>$optObj->union_id ]);
                if( !$uObj ){
                    break;
                }
                $relObj = MgUserRel::findOne([ 'sub_user_openid'=>$uObj->open_id ] );
                if( !$relObj )
                    break;
                $ret['openid'] = $relObj->user_openid;
                $ret['msg'] = "您的好友 {$uObj->nickname} 已上线。";
                break;
            default:
                break;
        }
        return $ret;
    }
    
}