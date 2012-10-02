<?php $this->pageTitle = 'Почтовые шаблоны'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Переводы',
    'Управление',
);
?>

<h1>Управление переводами</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'translation-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'name',
        'desc',
        array(
            'class' => 'CButtonColumn',
            'template' => '{update}',
        ),
    ),
)); ?>
