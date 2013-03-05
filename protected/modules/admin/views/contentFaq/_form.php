<?php
/* @var $this ContentFaqController */
/* @var $model ContentFaq */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'content-faq-form',
    'enableAjaxValidation'=>false,
)); ?>

<p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
<?php echo $form->labelEx($model,'question'); ?>
<?php echo $form->textArea($model,'question',array('rows'=>3, 'cols'=>90)); ?>
<?php echo $form->error($model,'question'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'answer'); ?>
<?php $this->widget('ImperaviRedactorWidget', array(
    'model' => $model,
    'attribute' => 'answer',
    'name' => 'ContentFaq[answer]',
    'options' => array(
      'lang' => 'ru',
      'toolbar'=>'mini',
    ),
    'htmlOptions' => array(
      'rows' => 25,
      'cols' => 80,
      'style' => 'width:100%;height:300px;'
    ),
));
?>
<?php echo $form->error($model, 'answer'); ?>
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