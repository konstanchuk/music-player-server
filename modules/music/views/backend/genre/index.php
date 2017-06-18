<?php

use modules\music\ModuleAsset;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Tabs;
use yii\widgets\ActiveForm;
use modules\music\models\Genres;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\Button;

$this->title = 'Genres';
$this->params['breadcrumbs'][] = $this->title;
Yii::$app->getModule('music')->assets = ModuleAsset::register($this);

?>
    <div class="page-header">
        <h1>Genres</h1>
    </div>

    <div class="row">
        <div class="col-md-3">

            <div aria-label="Justified button group" role="group" class="btn-group btn-group-justified">
                <a role="button" class="btn btn-default"
                   href="<?php echo Yii::$app->urlManager->createUrl(['/music/genre']); ?>"><i
                            class="glyphicon glyphicon-plus"></i> Root genre</a>

                <?php if (Yii::$app->request->getQueryParam('parent_id') != ''): ?>
                    <a role="button" class="btn btn-default disabled" href="javascript:void(0)"><i
                                class="glyphicon glyphicon-plus"></i> Subgenre</a>
                <?php else: ?>
                    <a role="button" class="btn btn-default"
                       href="<?php echo Yii::$app->urlManager->createUrl(['/music/genre', 'parent_id' => Yii::$app->request->getQueryParam('id')]); ?>"><i
                                class="glyphicon glyphicon-plus"></i> Subgenre</a>
                <?php endif; ?>
            </div>

            <div class="clearfix">&nbsp;</div>

            <div id="yimd-genres-jstree">
                <?php
                $current_genre = Yii::$app->request->getQueryParam('id');
                ?>
                <?php echo Genres::createTreeList($parent_id = null, $current_genre); ?>
            </div>

        </div>
        <div class="col-md-9">

            <div class="genres-form tab-content" style="min-height:400px;">

                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                <nav class="navbar navbar-default navbar-static">
                    <div class="container-fluid">
                        <div class="navbar-header">
						<span class="navbar-brand">
							<?php if ($parentGenre): ?>
                                <?php echo Genres::printEditPath(Html::getAttributeValue($parentGenre, 'id')); ?> - New Subgenre
                            <?php else: ?>
                                <?php if ($model->id != ""): ?>
                                    <?php echo Genres::printEditPath(Html::getAttributeValue($model, 'id')); ?> - Update genre information
                                <?php else: ?>
                                    New Root Genre
                                <?php endif; ?>
                            <?php endif; ?>
						</span>
                        </div>
                        <div class="pull-right" style="margin-top:8px">
                            <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save Genre', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                </nav>


                <?php
                $tabItems = [];
                if ($model->id != '') {
                    $tabItems[] = [
                        'label' => 'View',
                        'content' => $this->render("_view", ['model' => $model, 'form' => $form]),
                        'active' => true,
                        'visible' => ($model->id == '') ? false : true
                    ];
                }

                $tabItems[] = [
                    'label' => 'General information',
                    'content' => $this->render("_form_general", ['model' => $model, 'form' => $form]),
                ];
                $tabItems[] = [
                    'label' => 'Genre image',
                    'content' => $this->render("_form_image", ['model' => $model, 'form' => $form]),
                ];

                if ($model->id != '') {
                    $tabItems[] = [
                        'label' => '<i class="glyphicon glyphicon-trash"></i> Delete',
                        'url' => Yii::$app->urlManager->createUrl(['music/genre/delete', 'id' => $model->id]),
                        'linkOptions' => ['onClick' => 'return confirm("Are you sure you want to delete this genre?");']
                    ];
                }

                echo Tabs::widget([
                    'items' => $tabItems,
                    'encodeLabels' => false
                ]);
                ?>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
    </div>

<?php
$this->registerJs(' 
jQuery(document).ready(function(){
	jQuery("#yimd-genres-jstree").jstree();
	jQuery("#yimd-genres-jstree").bind(
		"select_node.jstree", function(evt, data){
			url = data.node.a_attr.href;
			window.location.href = url;
		}
	);
});', \yii\web\View::POS_READY);
?>