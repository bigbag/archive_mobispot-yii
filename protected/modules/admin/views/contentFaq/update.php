<?php $this->pageTitle = 'FAQ'; ?>
<?php
$this->breadcrumbs = array(
  'Админка' => array('/admin/'),
  'Содержимое',
  'FAQ' => array('index'),
  $model->question,
  'Редактировать',
);

$this->menu = array(
  array('label' => 'Добавить ответ', 'url' => array('create')),
  array('label' => 'Управление ответами', 'url' => array('index')),
);
?>

<h1>Редактировать ответ на вопрос "<?php echo $model->question; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>