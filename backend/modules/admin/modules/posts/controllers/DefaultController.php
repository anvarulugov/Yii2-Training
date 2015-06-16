<?php

namespace backend\modules\admin\modules\posts\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionNew()
    {
			return $this->render('index');
    }
}
