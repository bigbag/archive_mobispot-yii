<?php $this->pageTitle = 'Типы страниц';?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Типы страниц',
    'Управление',
);

$this->menu = array(
    array('label' => 'Создать тип', 'url' => array('create')),
);
?>

<h1>Управление разделами страниц</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'page-category-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'desc',
        'pattern',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>
