<?php

use modules\music\models\Genres;

?>

    <div class="clearfix">&nbsp;</div>

<?= $form->field($model, 'image')->fileInput() ?>

<?php
if ($model->id != "") {
    echo Genres::getImage($model->id, 'medium', ['class' => 'thumbnail']);
}
?>