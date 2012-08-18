<?php
/* @var $this SpotController */
/* @var $model Spot */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'spot-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php echo $form->errorSummary($model); ?>
    <table class="detail-view" id="yw0">
        <tr class="even">
            <th><?php echo $form->label($model, 'name'); ?></th>
            <td><?php echo $model->name ?></td>
        </tr>
        <tr class="odd">
            <th><?php echo $form->label($model, 'discodes_id'); ?></th>
            <td><?php echo $model->discodes_id ?></td>
        </tr>
        <tr class="even">
            <th><?php echo $form->labelEx($model, 'spot_type_id'); ?></th>
            <td><?php echo $form->dropDownList($model, 'spot_type_id', CHtml::listData(SpotType::getSpotType($model->type), 'id', 'name')); ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'status'); ?></th>
            <td><?php echo $model->getStatus() ?></td>
        </tr>
        <tr class="even">
            <th><?php echo $form->labelEx($model, 'user_id'); ?></th>
            <td><?php echo ($model->user) ? $model->user->email : ""; ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'spot_hard_type_id'); ?></th>
            <td><?php echo $form->dropDownList($model, 'spot_hard_type_id', CHtml::listData(SpotHardType::getSpotHardType(), 'id', 'name')); ?></td>
        </tr>
        <tr class="even">
            <th><?php echo $form->labelEx($model, 'spot_hard'); ?></th>
            <td><?php echo $form->textField($model, 'spot_hard', array('size' => 32, 'maxlength' => 32)); ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'nfc'); ?></th>
            <td><?php echo $model->nfc ?></td>
        </tr>
        <tr class="even">
            <th>
                <?php echo $form->label($model, 'type'); ?></th>
            <td><?php echo $model->getType() ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'status'); ?></th>
            <td><?php echo $model->getStatus() ?></td>
        </tr>
        <tr class="even">
            <th>
                <?php echo $form->label($model, 'generated_date'); ?></th>
            <td><?php echo Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->generated_date) ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'registered_date'); ?></th>
            <td><?php echo Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->registered_date) ?></td>
        </tr>
        <tr class="even">
            <th>
                <?php echo $form->label($model, 'removed_date'); ?></th>
            <td><?php echo Yii::app()->dateFormatter->format("dd.MM.yy hh:mm", $model->removed_date) ?></td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->