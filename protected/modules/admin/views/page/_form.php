<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'page-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span> обязательны к заполнению.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'slug'); ?>
        <?php echo $form->textField($model, 'slug', array('size' => 30, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'slug'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'body'); ?>
        <?php $this->widget('ImperaviRedactorWidget', array(
        'model' => $model,
        'attribute' => 'body',
        'name' => 'Page[body]',
        'options' => array(
            'lang' => 'ru',
            'imageUpload' => '/admin/page/image',
            'imageUploadCallback' => "function(obj, json) { }",
        ),
        'htmlOptions' => array(
            'rows' => 25,
            'cols' => 80,
            'style' => 'width:100%;height:300px;'
        ),
    ));
        ?>
        <?php echo $form->error($model, 'body'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'keywords'); ?>
        <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 250)); ?>
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

    <div class="row">
        <?php echo $form->labelEx($model, 'template_id'); ?>
        <?php echo $form->dropDownList($model, 'template_id', PageTemplate::getTemplateArray()); ?>
        <?php echo $form->error($model, 'template_id'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>