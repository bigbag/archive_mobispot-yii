<?php $this->pageTitle = 'Доступные поля'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Доступные поля' => array('/admin/spotField/'),
    'Добавить'
);
?>

<h1>Добавить поле</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>