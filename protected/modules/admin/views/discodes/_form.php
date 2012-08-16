<?php
/* @var $this DiscodesController */
/* @var $model Discodes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discodes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<strong>ID:</strong> <?php echo $model->id ?>
	</div>
    <div class="row">
        <strong>Код:</strong> <?php echo $model->code ?>
    </div>
    <div class="row">
        <?php echo $form->label($model, 'premium'); ?>
        <?php echo $form->dropDownList($model, 'premium', $model->getPremiumList()); ?>
        <?php echo $form->error($model, 'premium'); ?>
    </div>
    <div class="row">
        <strong>Статус:</strong> <?php echo $model->getStatus() ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавть' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->