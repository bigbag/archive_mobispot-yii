<?php
/* @var $this SpotHardTypeController */
/* @var $model SpotHardType */
/* @var $form CActiveForm */
?>

<div class="form">

  <?php
  $form = $this->beginWidget('CActiveForm', array(
      'id' => 'spot-hard-type-form',
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
      <th><?php echo $form->label($model, 'desc'); ?></th>
      <td><?php echo $form->textArea($model, 'desc', array('rows' => 6, 'cols' => 50)); ?></td>
    </tr>
    <tr class="even">
      <th><?php echo $form->labelEx($model, 'photo'); ?></th>
      <td>
        <?php if (isset($model->photo)): ?>
          <img id="hard_photo" src="/uploads/images/<?php echo $model->photo ?>">
        <?php endif; ?>
        <?php echo $form->hiddenField($model, 'photo'); ?>
        <div class="hard_photo">
          <input type="file" name="file_upload" id="add_photo"/>
          <noscript>
          <p>Please enable JavaScript to use file uploader.</p>
          </noscript>
        </div>
      </td>
    </tr>
  </table>
  <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
  </div>

  <?php $this->endWidget(); ?>

</div>

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/css/uploadifive.css'); ?>

<script type="text/javascript">
  $(function() {
    $("#add_photo").uploadify({
      'width': '167',
      'height': '21',
      'fileSizeLimit': '512KB',
      'fileTypeDesc': 'Images',
      uploadScript: '/admin/spotHardType/upload/',
      'formData': {'action': 'hard_image'},
      'removeTimeout': 10,
      'multi': false,
      'onError': function(file, errorCode, errorMsg, errorString) {
        alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
      },
      'onUploadComplete': function(file, data, response) {
        $('.hard_photo').html('<img src="/uploads/images/' + data + '" />');
        $('#SpotHardType_photo').val(data);
        $('#hard_photo').hide();
      }
    });
  });
</script>