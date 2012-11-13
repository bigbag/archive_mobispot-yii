<?php $this->pageTitle = 'Карусель'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Карусель',
);
?>

<?php
$this->menu=array(
    array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Управление иконками карусели</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'content-carousel-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'name',
        'desc',
        array(
            'name' => 'lang',
            'type' => 'raw',
            'value' => '$data->getLang()',
            'filter' => Lang::getLangArray(),
        ),
        array(
            'class'=>'CButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
)); ?>
