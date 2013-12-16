<?php $this->pageTitle = 'Почтовые шаблоны'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Почта',
    'Почтовые шаблоны',
    'Управление',
);

$this->menu = array(
    array('label' => 'Добавить шаблон', 'url' => array('create')),
);
?>

<h1>Управление шаблонами</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'mail-template-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'desc',
        array(
            'name' => 'lang',
            'type' => 'raw',
            'value' => '$data->getLang()',
            'filter' => Lang::getLangArray(),
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}',
        ),
    ),
));
?>
