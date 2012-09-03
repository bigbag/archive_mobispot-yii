<?php $this->pageTitle = 'ID'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'ID' => array('index'),
    $model->id,
    'Редактировать',
);
?>

<h1>Редактировать ДИС "<?php echo $model->id; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>