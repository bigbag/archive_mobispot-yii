<?php
/* @var $this SpotHardTypeController */
/* @var $model SpotHardType */

$this->breadcrumbs=array(
	'Spot Hard Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SpotHardType', 'url'=>array('index')),
	array('label'=>'Manage SpotHardType', 'url'=>array('admin')),
);
?>

<h1>Create SpotHardType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>