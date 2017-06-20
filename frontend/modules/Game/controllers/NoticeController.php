<?php

namespace frontend\modules\Game\controllers;

use yii\web\Controller;

/**
 * Default controller for the `Game` module
 */
class NoticeController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionUserOpt()
    {
        die( json_encode([
            'resultNo'=>0,
            'resultDesc'=>'请求成功！'
        ]) );
    }
    
}
