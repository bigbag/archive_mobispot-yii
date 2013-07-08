<?php $this->pageTitle = 'Типы исполнения спотов'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Типы исполнения спотов' => array('/admin/spotHardType/'),
    'Добавить'
);
?>

<h1>Добавить тип</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>