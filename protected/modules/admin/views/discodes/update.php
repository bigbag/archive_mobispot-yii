<?php $this->pageTitle = 'ДИС'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты' => array('/admin/spot/'),
    'ДИС' => array('index'),
    $model->id,
    'Редактировать',
);
?>

<h1>Редактировать ДИС "<?php echo $model->id; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>