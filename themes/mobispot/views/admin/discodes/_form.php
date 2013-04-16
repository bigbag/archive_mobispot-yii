<?php
/* @var $this DiscodesController */
/* @var $model Discodes */
/* @var $form CActiveForm */
?>

<div class="form">

  <?php
  $form=$this->beginWidget('CActiveForm', array(
      'id'=>'discodes-form',
      'enableAjaxValidation'=>false,
  ));
  ?>

  <?php echo $form->errorSummary($model); ?>
  <table class="detail-view" id="yw0">
    <tr class="even">
      <th><?php echo $form->label($model, 'id'); ?></th>
      <td><?php echo $model->id ?></td>
    </tr>
    <tr class="odd">
      <th><?php echo $form->label($model, 'premium'); ?></th>
      <td><?php echo $form->dropDownList($model, 'premium', $model->getPremiumList()); ?></td>
    </tr>
    <tr class="even">
      <th><?php echo $form->label($model, 'status'); ?></th>
      <td><?php echo $model->getStatus() ?></td>
    </tr>
  </table>
  <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>

    <?php $this->endWidget(); ?>

  </div>
  <!-- form -->