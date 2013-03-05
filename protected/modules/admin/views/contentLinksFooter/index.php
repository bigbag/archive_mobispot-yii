<?php $this->pageTitle = 'Ссылки в подвале'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Содержимое',
  'Ссылки в подвале',
);
?>

<?php
$this->menu=array(
  array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Управление ссылками</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'content-links-footer-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
      'link',
      'name',
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
