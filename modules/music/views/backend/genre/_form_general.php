<div class="clearfix">&nbsp;</div>

<?= $form->field($model, 'name')
    ->textInput(['maxlength' => 80])
    ->hint('Enter name for your genre.'); ?>
<?= $form->field($model, 'description')
    ->textarea(['rows' => 6])
    ->widget(\yii\redactor\widgets\Redactor::className())->hint('Add description to genre.'); ?>
<?= $form->field($model, 'is_active')
    ->radioList(array('1' => 'Active', '0' => 'Inactive')); ?>