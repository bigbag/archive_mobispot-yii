<?php $this->pageTitle='Пользователи'; ?>
<?php
$this->breadcrumbs=array(
    'Админка'=>array('/admin/'),
    'Пользователи'=>array('/admin/user/'),
    'Редактировать',
    $model->email,
);
?>
<h1>Редактировать данные пользователя <?php echo $model->email; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>