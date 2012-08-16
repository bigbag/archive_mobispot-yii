<?php
/* @var $this SpotTypeController */
/* @var $model SpotType */

$this->breadcrumbs=array(
	'Spot Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SpotType', 'url'=>array('index')),
	array('label'=>'Create SpotType', 'url'=>array('create')),
	array('label'=>'Update SpotType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SpotType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SpotType', 'url'=>array('admin')),
);
?>

<h1>View SpotType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'field',
	),
)); ?>
