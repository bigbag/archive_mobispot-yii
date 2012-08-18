<?php
/* @var $this SpotFieldController */
/* @var $model SpotField */

$this->breadcrumbs = array(
    'Spot Fields' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List SpotField', 'url' => array('index')),
    array('label' => 'Create SpotField', 'url' => array('create')),
    array('label' => 'Update SpotField', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete SpotField', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage SpotField', 'url' => array('admin')),
);
?>

<h1>View SpotField #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'name',
        'desc',
        'widget',
    ),
)); ?>
