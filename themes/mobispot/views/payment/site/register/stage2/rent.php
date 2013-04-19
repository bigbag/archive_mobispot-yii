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

<?php echo CHtml::activeTextArea(
  $model,
  'address',
  array(
    'width'=>'438px',
    'autocomplete'=>'off',
    'placeholder'=>'Адрес размещения оборудования *',
  )
);
?>
</div>

<?php echo CHtml::activeTextField(
  $model,
  'url',
  array(
    'class'=>'span6',
    'autocomplete'=>'off',
    'placeholder'=>'Веб-сайт компании',
  )
);
?>

<div class="toggle-active">
  <a class="checkbox agree" href="javascript:;"><i></i>Мне нужен доступ к API «Мобиспот. Корпоративные сервисы»</a>
</div>
<input value="" name="RegisterSelfForm[api]" id="RegisterSelfForm_api" type="hidden">

<h5>Набор подключаемых сервисов:</h5>
  <div class="row">
    <div class="seven mobile-two columns text-left">
      <label for="coffe" class=" inline">Кофе-машины</label>
    </div>
  <div class="five mobile-two columns">
    <input type="text" id="coffe" autocomplete="off" maxlength="4" placeholder="Количество" name="RegisterSelfForm[coffe]">
  </div>
</div>

<div class="row">
  <div class="seven mobile-two columns">
    <label for="pos" class=" inline">Решения для столовой</label>
  </div>
  <div class="five mobile-two columns">
    <input type="text" id="pos"  autocomplete="off" maxlength="4" placeholder="Количество" name="RegisterSelfForm[pos]">
  </div>
</div>