<?php $this->pageTitle='Типы спотов'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Споты'=>array('/admin/spot/'),
    'Типы спотов'=>array('/admin/spotType/'),
    'Редактировать',
    $model->name,
);
$this->menu=array(
    array('label'=>'Добавить тип', 'url'=>array('create')),
);
?>

<h1>Редактировать тип "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>