<?php

namespace modules\music\controllers\backend;

use Yii;
use modules\music\models\Genres;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class GenreController extends Controller
{
    public function actionIndex()
    {
        $model = new Genres();

        $parentGenre = false;

        if (Yii::$app->request->getQueryParam('id') != "") {
            $model = $this->findModel(Yii::$app->request->getQueryParam('id'));
        }

        if (Yii::$app->request->getQueryParam('parent_id') != "") {
            $model->parent_id = Yii::$app->request->getQueryParam('parent_id');
            $parentGenre = $this->findModel($model->parent_id);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $model->upload();
            if ($model->isNewRecord) {
                Yii::$app->getSession()->setFlash('success', 'Genre information has been stored.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->getSession()->setFlash('success', 'Genre information updated successfully.');
                $this->refresh();
            }
        } else {
            return $this->render('index', [
                'model' => $model,
                'parentGenre' => $parentGenre
            ]);
        }
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Genres::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}