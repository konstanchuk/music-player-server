<?php

namespace modules\music\controllers\api;

use yii\web\Controller;
use modules\music\models\Genres;


class GenreController extends Controller
{
    public function actionIndex()
    {
        return ['test' => 1];
    }

    public function actionGetAll()
    {
        return Genres::getAll(null, ['id', 'parent_id', 'name', 'description', 'image', 'position']);
    }
}