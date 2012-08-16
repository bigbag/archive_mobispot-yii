<?php
/* @var $this SpotHardTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Spot Hard Types',
);

$this->menu=array(
	array('label'=>'Create SpotHardType', 'url'=>array('create')),
	array('label'=>'Manage SpotHardType', 'url'=>array('admin')),
);
?>

<h1>Spot Hard Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
