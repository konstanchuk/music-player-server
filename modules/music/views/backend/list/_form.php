<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \modules\music\models\Track */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="music-track-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'genre_id', [
            'inputOptions' => [
                'class' => 'selectpicker '
            ]
        ]
    )->dropDownList(\modules\music\models\Genres::getHierarchy(), [
        'prompt' => 'Select genre',
        'class' => 'form-control required'
    ]);
    ?>

    <?= $form->field($model, 'trackFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>