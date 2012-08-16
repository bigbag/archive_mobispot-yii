<?php
/* @var $this SpotHardTypeController */
/* @var $model SpotHardType */

$this->breadcrumbs=array(
	'Spot Hard Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SpotHardType', 'url'=>array('index')),
	array('label'=>'Create SpotHardType', 'url'=>array('create')),
	array('label'=>'View SpotHardType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SpotHardType', 'url'=>array('admin')),
);
?>

<h1>Update SpotHardType <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>