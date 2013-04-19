<?php if (Yii::app()->user->hasFlash('info')): ?>
<div class="alert alert alert-info">
<?php echo Yii::app()->user->getFlash('info');?>
</div>
<?php endif;?>

<?php if (Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert alert-error">
<?php echo Yii::app()->user->getFlash('error');?>
</div>
<div class="control-group error">
<?php else:?>
<div class="control-group warning">
<?php endif;?>
<?php echo CHtml::activeTextField(
  $model,
  'name',
  array(
    'class'=>'span6',
    'autocomplete'=>'off',
    'placeholder'=>'Название компании *',
  )
);
?>
<?php echo CHtml::activeTextField(
  $model,
  'person',
  array(
    'class'=>'span6',
    'autocomplete'=>'off',
    'placeholder'=>'Контактное лицо *',
  )
);
?>
<?php echo CHtml::activeTextField(
  $model,
  'email',
  array(
    'class'=>'span5',
    'autocomplete'=>'off',
    'placeholder'=>'Email *',
  )
);
?>

<?php echo CHtml::activeTextField(
  $model,
  'count',
  array(
    'class'=>'span4',
    'autocomplete'=>'off',
    'placeholder'=>'Количество сотрудников *',
    'maxlength'=>'4',
  )
);
?>
</div>
<div>
Нам нужно точно узнать, к оборудованию какого из наших клиентов Вы хотели бы подключиться.<br />
Пожалуйста, заполните хотя бы одно из полей ниже.
</div>
<br />
<?php echo CHtml::activeTextField(
  $model,
  'parentName',
  array(
    'class'=>'span6',
    'autocomplete'=>'off',
    'placeholder'=>'Название компании-владельца оборудования',
  )
);
?>

<?php echo CHtml::activeTextArea(
  $model,
  '',
  array(
    'width'=>'438px',
    'autocomplete'=>'off',
    'placeholder'=>'Адрес размещения оборудования',
  )
);
?>

<?php echo CHtml::activeTextField(
  $model,
  'url',
  array(
    'class'=>'span6',
    'autocomplete'=>'off',
    'placeholder'=>'Домен владельца оборудования на mobispot.com',
  )
);
?>