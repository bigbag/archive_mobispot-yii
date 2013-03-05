<?php $this->pageTitle = 'Карусель'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Содержимое',
  'Карусель' => array('index'),
  'Добавление',
);

$this->menu = array(
  array('label' => 'Управление иконками карусели', 'url' => array('index')),
);
?>

<h1>Добавить иконку</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>