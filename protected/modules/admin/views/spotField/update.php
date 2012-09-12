<?php $this->pageTitle = 'Доступные поля'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Доступные поля' => array('/admin/spotField/'),
    'Редактировать',
    $model->name,
);
$this->menu = array(
    array('label' => 'Добавить поле', 'url' => array('create')),
);
?>

<h1>Редактировать поле "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>