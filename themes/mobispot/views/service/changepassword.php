<div id="main-container">
<div id="cont-block" class="center">
<div id="cont-block-760" class="center">
<div id="zag-cont-block"><?php echo Yii::t('user', 'Смена пароля')?></div>
<?php echo CHtml::beginForm(); ?>
<span class="error"><?php echo CHtml::errorSummary($form); ?></span>
<center><?php echo Yii::t('user', 'Введите новый пароль.')?>
<table class="form">
<tr>
<td>
<div class="txt-form">
<div class="txt-form-cl">
<?php echo CHtml::activeTextField($form, 'password',
  array(
    'class'=>'txt',
    'maxsize'=>50,
    'placeholder'=>Yii::t('user', 'Пароль')
)); ?>
<input type="hidden" name="token" id="token"
value="<?php echo Yii::app()->request->csrfToken?>">
</div>
</div>
</td>
</tr>
<tr>
<td>
<div class="txt-form">
<div class="txt-form-cl">
<?php echo CHtml::activeTextField($form, 'verifyPassword',
  array(
    'class'=>'txt',
    'maxsize'=>50,
    'placeholder'=>Yii::t('user', 'Повтор пароля')
)); ?>
</div>
</div>
</td>
</tr>
<tr>
<td>
<center>
<div class="round-btn" style="float:right">
<div class="round-btn-cl">
<input type="submit" class="" value="<?php echo Yii::t('user', 'Отправить')?>"/>
</div>
</div>
</center>
</td>
</tr>
</table>
</center>
<?php echo CHtml::endForm(); ?>
</div>
</div>
</div>
