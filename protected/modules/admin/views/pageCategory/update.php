<?php $this->pageTitle = 'Типы страниц'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Модели',
    'Типы страниц' => array('index'),
    $model->title,
    'Редактировать',
);

$this->menu = array(
    array('label' => 'Создать тип', 'url' => array('create')),
    array('label' => 'Управление типами страниц', 'url' => array('index')),
);
?>

<h1>Редактировать тип"<?php echo $model->title; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>