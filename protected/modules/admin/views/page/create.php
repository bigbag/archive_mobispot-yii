<?php $this->pageTitle='Cтраницы'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Содержимое',
    'Страницы'=>array('index'),
    'Добавление',
);

$this->menu=array(
    array('label'=>'Управление страницами', 'url'=>array('index')),
);
?>

<h1>Добавить страницу</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>