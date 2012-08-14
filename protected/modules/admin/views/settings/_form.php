<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'settings-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'desc'); ?>
        <?php echo $form->textField($model, 'desc', array('size' => 50, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'desc'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'value'); ?>
        <?php echo $form->textArea($model, 'value', array('rows' => 5, 'cols' => 60)); ?>
        <?php echo $form->error($model, 'value'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->