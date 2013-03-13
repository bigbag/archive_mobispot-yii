<?php $this->pageTitle = 'Настройки'; ?>
<?php

$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Общие',
    'Настройки' => array('index'),
    $model->name,
    'Изменить',
);
?>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>