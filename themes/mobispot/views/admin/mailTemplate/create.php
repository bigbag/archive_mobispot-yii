<?php $this->pageTitle='Почтовые шаблоны'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Почта',
    'Почтовые шаблоны'=>array('index'),
    'Добавление',
);

$this->menu=array(
    array('label'=>'Управление шаблонами', 'url'=>array('index')),
);
?>

<h1>Добавить шаблон</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>