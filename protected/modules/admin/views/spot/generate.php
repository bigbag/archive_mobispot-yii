<?php $this->pageTitle = 'Активные споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты',
    'Активные споты' => array('index'),
    'Генерировать'
);

$this->menu = array(
    array('label' => 'Управление', 'url' => array('index')),
    array('label' => 'Активировать', 'url' => array('activate')),
);
?>

<div class="form">
    <?php echo CHtml::beginForm();?>
    <div class="row">
        <label>Выберите тип ДИС: </label>
        <?php echo CHtml::dropDownList('Spot[premium]', 'premium', Discodes::getPremiumList())?>
    </div>
    <div class="row">
        <label>Выберите тип генерируемого спота: </label>
        <?php echo CHtml::dropDownList('Spot[type]', 'type', Spot::getTypeList())?>
    </div>
    <div class="row">
        <label>Введите количество генерируемых спотов: </label>
        <?php echo CHtml::textField('Spot[count]', '1', array('size'=>4,'maxlength'=>5)); ?>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Сгенерировать'); ?>
    </div>
    <?php echo CHtml::endForm();?>

</div>