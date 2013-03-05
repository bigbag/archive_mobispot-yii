<?php $this->pageTitle = 'Персональный спот, поля'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Споты' => array('/admin/spot/'),
  'Персональный спот, поля' => array('/admin/spotPersonalField/'),
  'Управление'
);
$this->menu = array(
  array('label' => 'Добавить поле', 'url' => array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spot-personal-field-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
      'name',
      'placeholder',
      'ico',
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
