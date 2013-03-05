<?php $this->pageTitle = 'Почтовые шаблоны'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Почта',
  'Почтовые шаблоны' => array('index'),
  $model->name,
  'Редактировать',
);

$this->menu = array(
  array('label' => 'Добавить шаблон', 'url' => array('create')),
  array('label' => 'Управление шаблонами', 'url' => array('index')),
);
?>

<h1>Редактировать шаблон "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>