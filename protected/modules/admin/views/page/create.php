<?php $this->pageTitle = 'Cтраницы';?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Модели',
    'Страницы' => array('index'),
    'Создать',
);

$this->menu = array(
    array('label' => 'Управление страницами', 'url' => array('index')),
);
?>

<h1>Создать страницу</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>