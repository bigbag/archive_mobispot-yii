<?php $this->pageTitle='FAQ'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Содержимое',
    'FAQ',
    'Управление',
);

$this->menu=array(
    array('label'=>'Добавить ответ', 'url'=>array('create')),
);
?>

<h1>Управление ответами</h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'content-faq-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'question',
        array(
            'name'=>'lang',
            'type'=>'raw',
            'value'=>'$data->getLang()',
            'filter'=>Lang::getLangArray(),
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}'
        ),
    ),
));
?>
