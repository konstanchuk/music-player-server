<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel modules\music\models\TrackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Track List');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="music-track-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Add Track'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'title',
            [
                'attribute' => 'updated_at',
                'value' => 'updated_at',
                'filter' => \yii\jui\DatePicker::widget(['language' => 'en', 'name' => 'updated_at']),
                'format' => 'datetime',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>