<?php
/* @var $this SpotPersonalFieldController */
/* @var $model SpotPersonalField */
/* @var $form CActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('CActiveForm', array(
      'id' => 'spot-personal-field-form',
      'enableAjaxValidation' => false,
  ));
  ?>

  <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

  <?php echo $form->errorSummary($model); ?>

  <div class="row">
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 300)); ?>
    <?php echo $form->error($model, 'name'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'ico'); ?>

    <?php if (isset($model->ico)): ?>
      <img id="hard_photo" src="/uploads/ico/<?php echo $model->ico ?>" alt="ico"/>
    <?php endif; ?>
    <?php echo $form->hiddenField($model, 'ico'); ?>
    <br />
    <div class="hard_photo">
      <input type="file" name="file_upload" id="add_photo"/>
      <noscript>
      <p>Please enable JavaScript to use file uploader.</p>
      </noscript>
    </div>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'placeholder'); ?>
    <?php echo $form->textField($model, 'placeholder', array('size' => 60, 'maxlength' => 300)); ?>
    <?php echo $form->error($model, 'placeholder'); ?>
  </div>

  <div class="row">
    <?php echo $form->labelEx($model, 'type'); ?>
    <?php echo $form->dropDownList($model, 'type', $model->getTypeList()); ?>
    <?php echo $form->error($model, 'type'); ?>
  </div>

  <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/css/uploadifive.css'); ?>

<script type="text/javascript">
  $(function() {
    $("#add_photo").uploadifive({
      'width': '70px',
      'height': '21',
      'fileTypeDesc': 'Images',
      uploadScript: '/admin/spotPersonalField/upload/',
      'formData': {'action': 'ico'},
      'removeTimeout': 10,
      'buttonText': 'select',
      'multi': false,
      'onError': function(errorType) {
        alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
      },
      'onUploadComplete': function(file, data, response) {
        $('.hard_photo').html('<img src="/uploads/ico/' + data + '" />');
        $('#SpotPersonalField_ico').val(data);
        $('#hard_photo').hide();
      }
    });
  });
</script>