<?php
/* @var $this SpotFieldController */
/* @var $model SpotField */

$this->breadcrumbs=array(
	'Spot Fields'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SpotField', 'url'=>array('index')),
	array('label'=>'Create SpotField', 'url'=>array('create')),
	array('label'=>'View SpotField', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage SpotField', 'url'=>array('admin')),
);
?>

<h1>Update SpotField <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>