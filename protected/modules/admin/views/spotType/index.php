<?php $this->pageTitle = 'Типы спотов'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Типы спотов' => array('/admin/spotType/'),
    'Управление'
);
$this->menu = array(
    array('label' => 'Добавить тип', 'url' => array('create')),
);
?>

<h1>Типы спотов</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spot-type-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'pattern',
        'desc',
        array(
            'name' => 'type',
            'type' => 'raw',
            'value' => '$data->getType()',
            'filter' => $model->getTypeList(),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
)); ?>