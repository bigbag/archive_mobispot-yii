<?php
/* @var $this SpotTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spot Types',
);

$this->menu=array(
	array('label'=>'Create SpotType', 'url'=>array('create')),
	array('label'=>'Manage SpotType', 'url'=>array('admin')),
);
?>

<h1>Spot Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
