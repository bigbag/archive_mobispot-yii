<?php
/* @var $this SpotController */
/* @var $model Spot */

$this->breadcrumbs=array(
	'Spots'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Spot', 'url'=>array('index')),
	array('label'=>'Create Spot', 'url'=>array('create')),
	array('label'=>'Update Spot', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Spot', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Spot', 'url'=>array('admin')),
);
?>

<h1>View Spot #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'discodes_id',
		'spot_type_id',
		'user_id',
		'spot_hard_type_id',
		'spot_hard',
		'nfc',
		'type',
		'status',
		'generated_date',
		'registerered_date',
		'removed_date',
	),
)); ?>
