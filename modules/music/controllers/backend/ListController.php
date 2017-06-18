<?php
namespace modules\music\controllers\backend;

use modules\music\models\Track;
use modules\music\models\TrackSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;


class ListController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new TrackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        /** @var Track $model */
        $model = Yii::createObject(Track::className());

        if ($this->saveTrack($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     *  stupid quick fix
     *  it isn't for a production
     */
    protected function saveTrack(Track $model)
    {
        if (Yii::$app->request->isPost) {

            $model->trackFile = UploadedFile::getInstance($model, 'trackFile');

            $filename = md5($model->trackFile->baseName) . uniqid() . '.' . $model->trackFile->extension;
            $model->trackFile->saveAs('uploads/' . $filename);

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->file = $filename;
                return $model->save();
            }
        }
        return false;
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->saveTrack($model)) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = Track::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}