<?php $this->pageTitle='Ссылки в подвале'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Содержимое',
    'Ссылки в подвале'=>array('index'),
    'Добавление',
);

$this->menu=array(
    array('label'=>'Управление ссылками', 'url'=>array('index')),
);
?>

<h1>Добавить ссылку</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>