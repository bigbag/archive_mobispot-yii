<?php
/* @var $this SpotHardTypeController */
/* @var $model SpotHardType */

$this->breadcrumbs=array(
	'Spot Hard Types'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List SpotHardType', 'url'=>array('index')),
	array('label'=>'Create SpotHardType', 'url'=>array('create')),
	array('label'=>'Update SpotHardType', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SpotHardType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SpotHardType', 'url'=>array('admin')),
);
?>

<h1>View SpotHardType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'desc',
		'photo',
	),
)); ?>
