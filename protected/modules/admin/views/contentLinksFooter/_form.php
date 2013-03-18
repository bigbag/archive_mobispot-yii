<?php
/* @var $this ContentLinksFooterController */
/* @var $model ContentLinksFooter */
/* @var $form CActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('CActiveForm', array(
      'id' => 'content-links-footer-form',
      'enableAjaxValidation' => false,
  ));
  ?>

  <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

  <?php echo $form->errorSummary($model); ?>

  <div class="row">
    <?php echo $form->labelEx($model, 'link'); ?>
    <?php echo $form->textField($model, 'link', array('size' => 60, 'maxlength' => 150)); ?>
    <?php echo $form->error($model, 'link'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 300)); ?>
    <?php echo $form->error($model, 'name'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'lang'); ?>
    <?php echo $form->dropDownList($model, 'lang', Lang::getLangArray()); ?>
    <?php echo $form->error($model, 'lang'); ?>
  </div>

  <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- form -->