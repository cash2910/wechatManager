<?php

namespace frontend\modules\Wechat\controllers;

use yii\web\Controller;

/**
 * Default controller for the `Wechat` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actionSharePage()
    {
        return $this->renderPartial('share_page');
    }
}
