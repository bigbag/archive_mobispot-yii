<?php
/* @var $this SpotController */
/* @var $model Spot */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'spot-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discodes_id'); ?>
		<?php echo $form->textField($model,'discodes_id'); ?>
		<?php echo $form->error($model,'discodes_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spot_type_id'); ?>
		<?php echo $form->textField($model,'spot_type_id'); ?>
		<?php echo $form->error($model,'spot_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spot_hard_type_id'); ?>
		<?php echo $form->textField($model,'spot_hard_type_id'); ?>
		<?php echo $form->error($model,'spot_hard_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'spot_hard'); ?>
		<?php echo $form->textField($model,'spot_hard',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'spot_hard'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nfc'); ?>
		<?php echo $form->textField($model,'nfc',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'nfc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'generated_date'); ?>
		<?php echo $form->textField($model,'generated_date'); ?>
		<?php echo $form->error($model,'generated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'registerered_date'); ?>
		<?php echo $form->textField($model,'registerered_date'); ?>
		<?php echo $form->error($model,'registerered_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'removed_date'); ?>
		<?php echo $form->textField($model,'removed_date'); ?>
		<?php echo $form->error($model,'removed_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->