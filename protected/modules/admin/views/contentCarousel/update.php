<?php $this->pageTitle = 'Карусель'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Содержимое',
  'Карусель' => array('index'),
  $model->name,
  'Редактировать',
);

$this->menu = array(
  array('label' => 'Добавить иконку', 'url' => array('create')),
  array('label' => 'Управление иконками карусели', 'url' => array('index')),
);
?>
<h1>Редактировать иконку <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>