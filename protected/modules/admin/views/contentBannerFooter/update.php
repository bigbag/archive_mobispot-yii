<?php $this->pageTitle='Баннеры на главной'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Содержимое',
    'Баннеры на главной'=>array('index'),
    $model->id,
    'Редактировать',
);

$this->menu=array(
    array('label'=>'Добавить баннер', 'url'=>array('create')),
    array('label'=>'Управление баннерами', 'url'=>array('index')),
);
?>
<h1>Редактировать баннер <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>