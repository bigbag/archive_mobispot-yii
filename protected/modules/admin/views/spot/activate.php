<?php $this->pageTitle = 'Активные споты'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Споты',
    'Активные споты' => array('index'),
    'Активировать'
);

$this->menu = array(
    array('label' => 'Управление', 'url' => array('index')),
    array('label' => 'Генерировать', 'url' => array('generate')),
);
?>