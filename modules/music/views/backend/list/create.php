<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model modules\music\models\Track */

$this->title = Yii::t('app', 'Add Track');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Track List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="music-track-create">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>