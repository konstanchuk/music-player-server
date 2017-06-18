<?php

namespace modules\music\controllers\api;

use yii\web\Controller;
use modules\music\models\Track;


class ListController extends Controller
{
    public function actionIndex()
    {
        return ['test' => 1];
    }

    public function actionGetAll()
    {
        return Track::find()->select('title,file,genre_id')->asArray()->all();
    }
}