<?php $this->pageTitle = 'Споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('index'),
    'Генерировать'
);

$this->menu = array(
    array('label' => 'Управление', 'url' => array('index')),
);
?>
<h1>Генерация спотов</h1>
<div class="form">
  <?php echo CHtml::beginForm(); ?>
  <div class="row">
    <label>Выберите тип ДИС: </label>
    <?php echo CHtml::dropDownList('SpotGenerate[premium]', 'premium', Spot::getPremiumList()) ?>
  </div>
  <div class="row">
    <label>Введите количество генерируемых спотов: </label>
    <?php echo CHtml::textField('SpotGenerate[count]', '1', array('size' => 2, 'maxlength' => 3)); ?>
  </div>
  <div class="row">
    <label>Активировать споты после генерации? </label>
    <?php echo CHtml::radioButtonList('SpotGenerate[activate]', 0, array(0 => 'Нет', 1 => 'Да'), array('separator' => ' ', 'template' => '{label} {input}')); ?>
  </div>
  <div class="row buttons">
    <?php echo CHtml::submitButton('Сгенерировать'); ?>
  </div>
  <?php echo CHtml::endForm(); ?>
</div>