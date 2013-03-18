<?php $this->pageTitle='Cтраницы'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Содержимое',
    'Страницы',
    'Управление',
);

$this->menu=array(
    array('label'=>'Добавить страницу', 'url'=>array('create')),
);
?>

<h1>Управление страницами</h1>


<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'page-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'slug',
        array(
            'name'=>'user_id',
            'type'=>'raw',
            'value'=>'($data->user)?$data->user->email:""',
        ),
        'title',
        array(
            'name'=>'lang',
            'type'=>'raw',
            'value'=>'$data->getLang()',
            'filter'=>Lang::getLangArray(),
        ),
        array(
            'name'=>'status',
            'type'=>'raw',
            'value'=>'$data->getStatus()',
            'filter'=>$model->getStatusList(),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
));
?>
