<?php
/* @var $this ContentCarouselController */
/* @var $model ContentCarousel */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'content-carousel-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'desc'); ?>
        <?php echo $form->textArea($model, 'desc', array('rows' => 6, 'cols' => 50)); ?>
		<?php echo $form->error($model,'desc'); ?>
	</div>
    <div class="row">
        <?php if (isset($model->image)): ?>
        <img id="hard_photo" src="/uploads/blocks/<?php echo $model->image?>">
        <?php endif;?>
        <?php echo $form->hiddenField($model, 'image'); ?>
        <div class="hard_photo">
            <input type="file" name="file_upload" id="add_photo"/>
            <noscript>
                <p>Please enable JavaScript to use file uploader.</p>
            </noscript>
        </div>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'lang'); ?>
        <?php echo $form->dropDownList($model, 'lang', Lang::getLangArray()); ?>
        <?php echo $form->error($model, 'lang'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->

<?php Yii::app()->getClientScript()->registerScriptFile('/themes/mobispot/js/jquery.uploadifive.min.js'); ?>
<?php Yii::app()->getClientScript()->registerCssFile('/themes/mobispot/css/uploadifive.css'); ?>
<script type="text/javascript">
    $(function () {
        $("#add_photo").uploadifive({
            'width':'167',
            'height':'21',
            'fileTypeDesc':'Images',
            uploadScript:'/admin/contentCarousel/upload/',
            'formData':{'action':'carousel_ico_'},
            'removeTimeout':10,
            'multi':false,
            'onError':function (file, errorCode, errorMsg, errorString) {
                alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            },
            'onUploadComplete':function (file, data, response) {
                $('.hard_photo').html('<img src="/uploads/blocks/' + data + '" />');
                $('#ContentCarousel_image').val(data);
                $('#hard_photo').hide();
            }
        });
    });
</script>