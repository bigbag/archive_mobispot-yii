<?php
/* @var $this MailTemplateController */
/* @var $model MailTemplate */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'mail-template-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'desc'); ?>
        <?php echo $form->textArea($model, 'desc', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'desc'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'slug'); ?>
        <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 300)); ?>
        <?php echo $form->error($model, 'slug'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'lang'); ?>
        <?php echo $form->dropDownList($model, 'lang', Lang::getLangArray()); ?>
        <?php echo $form->error($model, 'lang'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'subject'); ?>
        <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'subject'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo $form->textArea($model, 'content', array('rows' => 30, 'cols' => 100, 'id' => 'code', 'class' => 'code')); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/codemirror/codemirror.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/css/codemirror.css'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/codemirror/javascript.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/codemirror/htmlmixed.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/codemirror/css.js'); ?>
<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/codemirror/xml.js'); ?>


<script type="text/javascript">
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {mode:"text/html", tabMode:"indent", lineNumbers:true});
</script>