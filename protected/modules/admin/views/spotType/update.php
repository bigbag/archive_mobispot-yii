<?php
/* @var $this SpotTypeController */
/* @var $model SpotType */

$this->breadcrumbs=array(
	'Spot Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SpotType', 'url'=>array('index')),
	array('label'=>'Create SpotType', 'url'=>array('create')),
	array('label'=>'View SpotType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SpotType', 'url'=>array('admin')),
);
?>

<h1>Update SpotType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>