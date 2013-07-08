<?php
/* @var $this SpotTypeController */
/* @var $model SpotType */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $this->widget('ext.jqrelcopy.JQRelcopy', array(
        'id' => 'copylink',
        'removeText' => CHtml::image('/themes/mobispot/images/form/delete.png'),
        'removeHtmlOptions' => array('style' => 'color:red'),
        'options' => array(
            'copyClass' => 'newcopy',
            'limit' => 10,
            'clearInputs' => true,
        )
    ));
    ?>



    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'spot-type-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>
    <table class="detail-view" id="yw0">
        <tr class="even">
            <th><?php echo $form->labelEx($model, 'name'); ?></th>
            <td><?php echo $form->textField($model, 'name', array('size' => 30, 'maxlength' => 150)); ?></td>
        </tr>
        <tr class="odd">

            <th><?php echo $form->labelEx($model, 'pattern'); ?></th>
            <td><?php echo $form->textField($model, 'pattern', array('size' => 30, 'maxlength' => 150)); ?></td>
        </tr>
        <tr class="even">
            <th><?php echo $form->label($model, 'desc'); ?></th>
            <td><?php echo $form->textArea($model, 'desc', array('rows' => 6, 'cols' => 50)); ?></td>
        </tr>
        <tr class="odd">
            <th>
                <?php echo $form->label($model, 'fields'); ?>
                <a id="copylink" href="#" rel=".copy">Добавить</a>
            </th>
            <td><?php if ($model->fields): ?>
                    <?php foreach ($model->fields as $key => $value): ?>
                        <div class="row">
                            <?php echo CHtml::textField('SpotType[fields][name][]', $key); ?>
                            <?php
                            echo $form->dropDownList(
                                    $model, 'fields[field_id][]', CHtml::listData(SpotField::getSpotFields(), 'field_id', 'desc'), array('options' => array($value => array('selected' => true)))
                            );
                            ?>
                            <a onclick="$(this).parent().remove();
                                    return false;" href="#"><img
                                    src="/themes/mobispot/images/form/delete.png" alt=""></a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="row copy">
                    <?php echo CHtml::textField('SpotType[fields][name][]', ''); ?>
                    <?php echo $form->dropDownList($model, 'fields[field_id][]', CHtml::listData(SpotField::getSpotFields(), 'field_id', 'desc')); ?>
                </div>
            </td>
        </tr>
    </table>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->