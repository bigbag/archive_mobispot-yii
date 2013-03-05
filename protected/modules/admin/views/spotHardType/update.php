<?php $this->pageTitle = 'Типы исполнения спотов'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Споты' => array('/admin/spot/'),
  'Типы исполнения спотов' => array('/admin/spotHardType/'),
  'Редактировать',
  $model->name,
);
$this->menu = array(
  array('label' => 'Добавить тип', 'url' => array('create')),
  array('label' => 'Удалить', 'url' => '#', 'linkOptions' => array(
      'submit' => array('delete', 'id' => $model->id),
  'confirm' => 'Вы уверены что хотите данный тип?')),
);
?>

<h1>Редактировать тип "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>