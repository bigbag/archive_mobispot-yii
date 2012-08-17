<?php
/* @var $this SpotController */
/* @var $model Spot */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>32,'maxlength'=>300)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spot_hard_type_id'); ?>
        <?php echo $form->dropDownList($model, 'spot_hard_type_id', CHtml::listData(SpotHardType::getSpotHardType(), 'id', 'name'), array('empty' => '')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'spot_hard'); ?>
		<?php echo $form->textField($model,'spot_hard',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nfc'); ?>
		<?php echo $form->textField($model,'nfc',array('size'=>32,'maxlength'=>32)); ?>
	</div>

    <div class="row">
        <?php echo $form->label($model, 'premium'); ?>
        <?php echo $form->dropDownList($model, 'premium', $model->getPremiumList(), array('empty' => '')); ?>
    </div>

	<div class="row">
        <?php echo $form->label($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', $model->getTypeList(), array('empty' => '')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList(), array('empty' => '')); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'generated_date'); ?>
		<?php echo $form->textField($model,'generated_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'registered_date'); ?>
		<?php echo $form->textField($model,'registered_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'removed_date'); ?>
		<?php echo $form->textField($model,'removed_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Найти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->