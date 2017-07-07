<?php

namespace frontend\modules\Game\controllers;

use yii;
use yii\web\Controller;
use common\models\MgGameUseropt;

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
        yii::error("游戏参数：".json_encode( $_POST ) );
        $model = new MgGameUseropt();
        $model->setAttributes( Yii::$app->request->post() );
        if (  !$model->save() ) {
            yii::error( json_encode( $model->getErrors() ,JSON_UNESCAPED_UNICODE ) );
            $ret['resultNo'] = 90000;
            $ret['resultDesc'] = json_encode( $model->getErrors() ,JSON_UNESCAPED_UNICODE );
        }
        echo json_encode( $ret );
    }
}
