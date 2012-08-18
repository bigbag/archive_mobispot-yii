<?php
/* @var $this DiscodesController */
/* @var $model Discodes */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'premium'); ?>
        <?php echo $form->dropDownList($model, 'premium', $model->getPremiumList(), array('empty' => '')); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList(), array('empty' => '')); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Найти'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->