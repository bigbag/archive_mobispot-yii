<div id="main-container">
<div class="grayAllBlock rad6 shadow">
<div class="infoViz proc100 clr txtFLeft">
<p><?php echo $content->poyasneniya_9; ?></p>

<form action="" method="post">
<?php if ($error): ?>
<div class="errorSummary">
<ul>
<li><?php echo Yii::t('mobile', 'Необходимо заполнить все поля.')?></li>
</ul>
</div>
<?php endif; ?>
<?php echo CHtml::errorSummary($feedback); ?>
<table class="proc100">
<tr>
<td>
<?php echo CHtml::activeTextField($feedback, 'name',
  array(
    'placeholder' => Yii::t('mobile', 'Имя'),
    'class' => 'txt-100p rad6',
    'style' => 'display:' . (($content->imya_9 == 1) ? 'block' : 'none'),
)); ?>
</td>
</tr>
<tr>
<td>
<?php echo CHtml::activeTextField($feedback, 'phone',
  array(
    'placeholder' => Yii::t('mobile', 'Телефон'),
    'class' => 'txt-100p rad6',
    'style' => 'display:' . (($content->telefon_9 == 1) ? 'block' : 'none'),
)); ?>
</td>
</tr>
<tr>
<td>
<?php echo CHtml::activeTextField($feedback, 'email',
  array(
    'placeholder' => Yii::t('mobile', 'Email'),
    'class' => 'txt-100p rad6',
    'style' => 'display:' . (($content->email_9 == 1) ? 'block' : 'none'),
)); ?>
</td>
</tr>
<tr>
<td>
<?php echo CHtml::activeTextArea($feedback, 'comment',
  array(
    'placeholder' => Yii::t('mobile', 'Комментарий'),
    'rows' => 3,
    'class' => 'txt-100p txtArea rad6',
    'style' => 'display:' . (($content->kommentariy_9 == 1) ? 'block' : 'none'),
)); ?>
</td>
</tr>
</table>
<input type="submit" class="btn-round fright rad12 shadow"
value="<?php echo Yii::t('mobile', 'Отправить');?>"/>

</form>
</div>
</div>
</div>
