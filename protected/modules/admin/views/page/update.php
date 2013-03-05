<?php $this->pageTitle = 'Cтраницы'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Содержимое',
  'Страницы' => array('index'),
  $model->title,
  'Редактировать',
);

$this->menu = array(
  array('label' => 'Добавить страницу', 'url' => array('create')),
  array('label' => 'Управление страницами', 'url' => array('index')),
);
?>

<h1>Редактировать страницу "<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>