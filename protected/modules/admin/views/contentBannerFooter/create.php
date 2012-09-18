<?php $this->pageTitle = 'Баннеры на главной'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Баннеры на главной' => array('index'),
    'Добавление',
);

$this->menu = array(
    array('label' => 'Управление баннерами', 'url' => array('index')),
);
?>

<h1>Добавить баннер</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>