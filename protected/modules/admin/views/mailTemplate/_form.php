<?php
/* @var $this MailTemplateController */
/* @var $model MailTemplate */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mail-template-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'desc'); ?>
        <?php echo $form->textArea($model,'desc',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'desc'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'slug'); ?>
        <?php echo $form->textField($model,'slug',array('size'=>100,'maxlength'=>300)); ?>
        <?php echo $form->error($model,'slug'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'lang_id'); ?>
        <?php echo $form->dropDownList($model, 'lang_id', Lang::getLangArray()); ?>
        <?php echo $form->error($model, 'lang_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'subject'); ?>
        <?php echo $form->textField($model,'subject',array('size'=>100,'maxlength'=>150)); ?>
        <?php echo $form->error($model,'subject'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>20, 'cols'=>80)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->