<?php $this->pageTitle='Типы спотов'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Споты'=>array('/admin/spot/'),
    'Типы спотов'=>array('/admin/spotType/'),
    'Добавить'
);
?>

<h1>Добавить тип</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>