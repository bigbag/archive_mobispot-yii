<?php $this->pageTitle = 'FAQ'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'FAQ' => array('index'),
    'Добавление',
);

$this->menu = array(
    array('label' => 'Управление ответами', 'url' => array('index')),
);
?>

<h1>Добавить ответ</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>