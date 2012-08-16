<?php
/* @var $this SpotTypeController */
/* @var $model SpotType */

$this->breadcrumbs=array(
	'Spot Types'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SpotType', 'url'=>array('index')),
	array('label'=>'Manage SpotType', 'url'=>array('admin')),
);
?>

<h1>Create SpotType</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>