<?php $this->pageTitle = 'Типы страниц';?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Модели',
    'Типы страниц' => array('index'),
    'Создать',
);

$this->menu = array(
    array('label' => 'Управление типами страниц', 'url' => array('index')),
);
?>

<h1>Создать тип</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>