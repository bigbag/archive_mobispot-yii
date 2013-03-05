<?php $this->pageTitle = 'Доступные поля'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Споты' => array('/admin/spot/'),
  'Доступные поля' => array('/admin/spotField/'),
  'Управление'
);
$this->menu = array(
  array('label' => 'Добавить поле', 'url' => array('create')),
);
?>

<h1>Управление доступными для добавления полями</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'spot-field-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
      'name',
      'desc',
      'widget',
      array(
        'class' => 'CButtonColumn',
        'template' => '{update}',
      ),
    ),
)); ?>
