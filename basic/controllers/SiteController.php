<?php

namespace app\controllers;

use app\models\CommitsFiles;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new CommitsFiles();

        return $this->render('index', [

            'searchModel' => $searchModel,
        ]);
    }
}
