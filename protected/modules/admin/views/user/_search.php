<?php
/* @var $this SpotController */
/* @var $model Spot */
/* @var $form CActiveForm */
?>

<div class="wide form">

  <?php
  $form = $this->beginWidget('CActiveForm', array(
      'action' => Yii::app()->createUrl($this->route),
      'method' => 'get',
  ));
  ?>
  <div class="row">
    <?php echo $form->label($model, 'profile_sex'); ?>
    <?php echo $form->dropDownList($model, 'profile_sex', UserProfile::getSexList(), array('empty' => '')); ?>
  </div>


  <div class="row buttons">
    <?php echo CHtml::submitButton('Найти'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- search-form -->