<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\models\MgGameUseropt;
use common\service\weixin\WeChatService;
use common\models\MgUserRel;
use common\models\MgUsers;
use yii\helpers\ArrayHelper;
use common\models\MgUserActlog;
use yii\base\Object;
use common\service\game\GameService;
use common\service\game\StatisticsService;

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
            case '100003':  //用户消费
                //记录用户建立的8局游戏的房间
                $data = json_decode( $optObj->data, true );
                $score = abs( ArrayHelper::getValue($data, 'Total') );
                if( 28 == $score ){
                    //找到最近一次建立房间的房间号
                    $logs = MgGameUseropt::find()->where(['union_id'=>$optObj->union_id, 'opt_code'=>'100004'])->orderBy('add_time desc')->one();
                    if( !$logs )
                        break;
                    $data = json_decode( $logs->data , true);
                    $room_id = ArrayHelper::getValue($data, 'Room_id');
                    if( !$room_id )
                        break;
                    yii::error("记录房间:".$room_id);
                    $ret = GameService::getInstance()->addRoom([
                        'room_id'=> $room_id,
                        'total'=> $score,
                        'union_id'=> $optObj->union_id,
                    ]);
                }
                break;
            case '100005':    //退出房间
                //是否进行了8局游戏房间
                $data = json_decode( $optObj->data, true );
                $room_id =  ArrayHelper::getValue($data, 'Room_id');
                if( !$room_id )
                    break;
                $ret = GameService::getInstance()->getRoom( $room_id );
                if( !empty( $ret ) ){
                    //进行了一次 8局对弈
                    $uObj = MgUsers::findOne(['union_id'=>$optObj->union_id ]);
                    if( !$uObj ){
                        break;
                    }
                    StatisticsService::getInstance()->addActLog( $uObj, StatisticsService::PLAY_CODE, [
                        'room_id'=>$room_id
                    ]);                    
                }
                break;
            default:
                break;
        }
        return $ret;
    }
    
}