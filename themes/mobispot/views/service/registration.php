<?php $this->pageTitle=Yii::app()->name.' - '.Yii::t('user', "Registration");
$this->breadcrumbs=array(
  Yii::t('user', "Registration"),
);
?>

<h1><?php echo Yii::t('user', "Registration"); ?></h1>

<?php if (Yii::app()->user->hasFlash('registration')): ?>
<div class="success">
<?php echo Yii::app()->user->getFlash('registration'); ?>
</div>
<?php else: ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'registration-form',
    'enableAjaxValidation'=>true,
)); ?>

<p class="note"><?php echo Yii::t('user', 'Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
<?php echo $form->labelEx($model, 'email'); ?>
<?php echo $form->textField($model, 'email'); ?>
<?php echo $form->error($model, 'email'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'password'); ?>
<?php echo $form->passwordField($model, 'password'); ?>
<?php echo $form->error($model, 'password'); ?>
<p class="hint">
<?php echo Yii::t('user', "Minimal password length 5 symbols."); ?>
</p>
</div>

<div class="row">
<?php echo $form->labelEx($model, 'verifyPassword'); ?>
<?php echo $form->passwordField($model, 'verifyPassword'); ?>
<?php echo $form->error($model, 'verifyPassword'); ?>
</div>

<div class="row submit">
<?php echo CHtml::submitButton(Yii::t('user', "Register")); ?>
</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
<?php endif; ?>
