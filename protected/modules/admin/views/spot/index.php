<?php $this->pageTitle = 'Активные споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты',
    'Активные споты',
    'Управление'
);

$this->menu = array(
    array('label' => 'Сгенерировать', 'url' => array('generate')),
    array('label' => 'Активировать', 'url' => array('activate')),
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('spot-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
    'model' => $model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spot-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'discodes_id',
        'spot_type_id',
        array(
            'name' => 'user_id',
            'type' => 'raw',
            'value' => '($data->user)?$data->user->email:""',
        ),
        'spot_hard',
        array(
            'name' => 'type',
            'type' => 'raw',
            'value' => '$data->getType()',
            'filter' => $model->getTypeList(),
        ),
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$data->getStatus()',
            'filter' => $model->getStatusList(),
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
