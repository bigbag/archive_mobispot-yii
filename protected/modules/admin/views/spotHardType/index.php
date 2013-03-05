<?php $this->pageTitle = 'Типы исполнения спотов'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Споты' => array('/admin/spot/'),
  'Типы исполнения спотов' => array('/admin/spotHardType/'),
  'Управление'
);
$this->menu = array(
  array('label' => 'Добавить тип', 'url' => array('create')),
);
?>

<h1>Типы исполнения спотов</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spot-hard-type-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
      'name',
      'desc',
      array(
        'name' => 'photo',
        'filter' => false,
        'type' => 'raw',
        'value' => 'CHtml::link(CHtml::image("/uploads/images/tmb_".$data->photo, "photo"), "/uploads/images/".$data->photo, array("rel"=>"lightbox"))'
      ),
      array(
        'class' => 'CButtonColumn',
        'template' => '{update}',
      ),
    ),
)); ?>