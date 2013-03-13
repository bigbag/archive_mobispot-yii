<?php $this->pageTitle = 'Персональный спот, поля'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'Персональный спот, поля' => array('/admin/spotPersonalField/'),
    'Добавить'
);
?>

<h1>Добавить поле</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>