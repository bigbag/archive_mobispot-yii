<?php
/* @var $this SpotTypeController */
/* @var $model SpotType */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'spot-type-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>
    <table class="detail-view" id="yw0">
        <tr class="even">
            <th><?php echo $form->labelEx($model, 'name'); ?></th>
            <td><?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 150)); ?></td>
        </tr>
        <tr class="odd">
            <th><?php echo $form->label($model, 'desc'); ?></th>
            <td><?php echo $form->textArea($model, 'desc', array('rows' => 6, 'cols' => 50)); ?></td>
        </tr>
        <tr class="even">
            <th><?php echo $form->labelEx($model, 'field'); ?></th>
            <td><?php echo $form->textArea($model, 'field', array('rows' => 6, 'cols' => 50)); ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'type'); ?></th>
            <td><?php echo $form->dropDownList($model, 'type', $model->getTypeList()); ?></td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->