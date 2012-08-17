<?php
/* @var $this SpotFieldController */
/* @var $model SpotField */

$this->breadcrumbs=array(
	'Spot Fields'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SpotField', 'url'=>array('index')),
	array('label'=>'Manage SpotField', 'url'=>array('admin')),
);
?>

<h1>Create SpotField</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>