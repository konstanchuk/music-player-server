<?php

use modules\music\models\Genres;
use yii\helpers\Html;
use yii\widgets\DetailView;

?>

    <div class="clearfix">&nbsp;</div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'image',
            'value' => Genres::getImage($model->id, 'small', ['class' => 'thumbnail']),
            'format' => 'raw'
        ],
        'id',
        [
            'attribute' => 'parent_id',
            'value' => Html::a(Html::getAttributeValue($model, 'parentGenre[name]'), ['/music/genre', 'id' => $model->parent_id]),
            'format' => 'raw',
            'visible' => ($model->parent_id == 0) ? false : true
        ],
        'name',
        'description',
        [
            'attribute' => 'is_active',
            'value' => ($model->is_active == 1) ? "Active" : "Inactive",
            'format' => 'raw',
        ],
        [
            'attribute' => 'created_at',
            'value' => ($model->created_at != '') ? date('d M Y h:s') : "(not set)",
            'format' => 'raw',
        ],
        [
            'attribute' => 'updated_at',
            'value' => ($model->updated_at != '') ? date('d M Y h:s a') : "(not set)",
            'format' => 'raw',
        ]
    ],
]) ?>