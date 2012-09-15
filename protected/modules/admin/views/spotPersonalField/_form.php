<?php
/* @var $this SpotPersonalFieldController */
/* @var $model SpotPersonalField */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'spot-personal-field-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'ico'); ?>
        <?php echo $form->textField($model, 'ico', array('size' => 60, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'ico'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'placeholder'); ?>
        <?php echo $form->textField($model, 'placeholder', array('size' => 60, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'placeholder'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', $model->getTypeList()); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->