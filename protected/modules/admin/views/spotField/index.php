<?php
/* @var $this SpotFieldController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Spot Fields',
);

$this->menu = array(
    array('label' => 'Create SpotField', 'url' => array('create')),
    array('label' => 'Manage SpotField', 'url' => array('admin')),
);
?>

<h1>Spot Fields</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
)); ?>
