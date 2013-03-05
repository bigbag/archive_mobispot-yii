<?php $this->pageTitle = 'Баннеры на главной'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Содержимое',
  'Баннеры на главной',
);
?>

<?php
$this->menu=array(
  array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Управление баннерами</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'content-banner-footer-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
      'link',
      'title',
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
