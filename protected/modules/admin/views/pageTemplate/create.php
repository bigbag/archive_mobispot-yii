<?php $this->pageTitle = 'Шаблоны'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Шаблоны' => array('index'),
    'Добавление',
);

$this->menu = array(
    array('label' => 'Управление шаблонами', 'url' => array('index')),
);
?>

<h1>Добавить шаблон</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>