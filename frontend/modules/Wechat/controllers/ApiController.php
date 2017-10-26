<?php
namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;
use yii;
use yii\web\Response;
use common\models\MgUsers;
use common\components\WeixinLoginBehavior;
use common\components\CommonResponse;
use common\service\users\UserService;


/**
 * Default controller for the `Wechat` module
 */
class ApiController extends Controller
{
    public $enableCsrfValidation = false;
    public $open_id = '';
    public $user_data = [];
    
    public function behaviors(){
        return [
            'access' => [
                'class' => WeixinLoginBehavior::className(),
                'actions' => [
                    'upgrade-level'
                ],
            ]
        ];
    }

    //获取代理推广图片二维码
    public function actionGetQrPic(){
        $proxyId = yii::$app->request->get('pid');
        $pObj = MgUsers::findOne(['id'=>$proxyId,'is_bd'=>MgUsers::IS_BD]);
        if( !$pObj ){
            return '';
        }
        $proxyImage = "./images/proxys/proxy_{$pObj->id}.png";
        Yii::$app->response->format = Response::FORMAT_RAW;
        Header("Content-type: image/png");
        if( !file_exists($proxyImage) ){
            require_once yii::$app->basePath.'/../common/components/qrcode/phpqrcode/qrlib.php';
            $logo = './images/head_logo.png';
            \QRcode::png( Yii::$app->urlManager->createAbsoluteUrl( ['/Wechat/default/show-proxy-link','id'=>$pObj->id ] ), $proxyImage, 0, 8);
            $QR = imagecreatefromstring(file_get_contents($proxyImage));
            $logo = imagecreatefromstring(file_get_contents($logo));
            $QR_width = imagesx($QR);//二维码图片宽度
            $QR_height = imagesy($QR);//二维码图片高度
            $logo_width = imagesx($logo);//logo图片宽度
            $logo_height = imagesy($logo);//logo图片高度
            $logo_qr_width = $QR_width / 6;
            $scale = $logo_width/$logo_qr_width;
            $logo_qr_height = $logo_height/$scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            //重新组合图片并调整大小
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
                $logo_qr_height, $logo_width, $logo_height);
            
            ImagePng($QR, $proxyImage);
        }else{
            $QR = imagecreatefromstring( file_get_contents( $proxyImage ) );
        }
        //输出图片
        ImagePng( $QR );
    }
    
    //提升用户等级
    public function actionUpgradeLevel(){
        if( ($fid = yii::$app->request->get('fid') ) != true  )
            CommonResponse::end(['isOk'=>'0','msg'=>'好友信息错误']);
        $uObj = MgUsers::findOne( ['open_id'=>$this->open_id ] );
        //判断是否为自己的好友
        $friendObj = MgUsers::findOne( ['id'=>$fid] );
        $rels = explode("-",$friendObj->user_rels);
        $pid = array_pop( $rels );
        if( $pid != $uObj->id )
            CommonResponse::end(['isOk'=>'0','msg'=>'好友信息错误.']);
        $ret = UserService::getInstance()->upgradeLevel( $uObj, $friendObj ,[
            'ratio'=> yii::$app->request->get('ratio'),
            'role' => yii::$app->request->get('role')
        ]);
        CommonResponse::end($ret);
    }
}