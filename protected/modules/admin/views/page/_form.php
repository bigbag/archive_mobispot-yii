<div class="form">

  <?php
  $form=$this->beginWidget('CActiveForm', array(
      'id'=>'page-form',
      'enableAjaxValidation'=>false,
  ));
  ?>

  <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

  <?php echo $form->errorSummary($model); ?>

  <div class="row">
    <?php echo $form->labelEx($model, 'title'); ?>
    <?php echo $form->textField($model, 'title', array('size'=>60, 'maxlength'=>150)); ?>
    <?php echo $form->error($model, 'title'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'slug'); ?>
    <?php echo $form->textField($model, 'slug', array('size'=>30, 'maxlength'=>150)); ?>
    <?php echo $form->error($model, 'slug'); ?>
  </div>

  <div class="row">
    <a class="get_menu" href="#"><?php echo $form->labelEx($model, 'menu'); ?></a>
    <div class="menu" style="display: none;">
      <?php echo $form->textArea($model, 'menu', array('rows'=>10, 'cols'=>100, 'id'=>'code', 'class'=>'code')); ?>
      <?php echo $form->error($model, 'menu'); ?>
    </div>

  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'body'); ?>
    <?php
    $this->widget('ImperaviRedactorWidget', array(
        'model'=>$model,
        'attribute'=>'body',
        'name'=>'Page[body]',
        'options'=>array(
            'lang'=>'ru',
            'imageUpload'=>'/admin/page/image',
            'imageUploadCallback'=>"function(obj, json) { }",
        ),
        'htmlOptions'=>array(
            'rows'=>25,
            'cols'=>80,
            'style'=>'width:100%;height:300px;'
        ),
    ));
    ?>
    <?php echo $form->error($model, 'body'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'keywords'); ?>
    <?php echo $form->textField($model, 'keywords', array('size'=>60, 'maxlength'=>150)); ?>
    <?php echo $form->error($model, 'keywords'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'description'); ?>
    <?php echo $form->textField($model, 'description', array('size'=>60, 'maxlength'=>250)); ?>
    <?php echo $form->error($model, 'description'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'lang'); ?>
    <?php echo $form->dropDownList($model, 'lang', Lang::getLangArray()); ?>
    <?php echo $form->error($model, 'lang'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'status'); ?>
    <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
    <?php echo $form->error($model, 'status'); ?>
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
  var editor=CodeMirror.fromTextArea(document.getElementById("code"), {mode: "text/html", tabMode: "indent", lineNumbers: true});
  $(document).ready(function() {
    $('a.get_menu').click(function() {
      if ($('div.menu').is(':visible')) {
        $('div.menu').hide();
      }
      else {
        $('div.menu').show();
      }

    });
  });
</script>