<?php $this->pageTitle = 'Ссылки в подвале'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Ссылки в подвале' => array('index'),
    $model->link,
    'Редактировать',
);

$this->menu = array(
    array('label' => 'Добавить ссылку', 'url' => array('create')),
    array('label' => 'Управление ссылками', 'url' => array('index')),
);
?>
<h1>Редактировать ссылку <?php echo $model->link; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>