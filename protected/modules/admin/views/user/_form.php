<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php echo $form->errorSummary($model); ?>
    <table class="detail-view" id="yw0">
        <tr class="even">
            <th><?php echo $form->label($model, 'email'); ?></th>
            <td><?php echo $model->email ?></td>
        </tr>
        <tr class="odd">
            <th><?php echo $form->label($model, 'name'); ?></th>
            <td><?php echo (!empty($model->profile->name))?$model->profile->name:'' ?></td>
        </tr>
        <tr class="even">
            <th><?php echo $form->label($model, 'email'); ?></th>
            <td><?php echo $model->email ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'creation_date'); ?>
            </th>
            <td>
                <?php echo Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->creation_date) ?>
            </td>
        </tr>
        <tr class="even">
            <th>
                <?php echo $form->label($model, 'lastvisit'); ?></th>
            <td>
                <?php echo Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->lastvisit) ?>
            </td>
        </tr>
        <tr class="odd">
            <th><?php echo $form->label($model, 'type'); ?></th>
            <td><?php echo $form->dropDownList($model, 'status', $model->getTypeList()); ?></td>
        </tr>
        <tr class="even">
            <th>
                <?php echo $form->label($model, 'status'); ?>
            </th>
            <td><?php echo $model->getStatus()?></td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->