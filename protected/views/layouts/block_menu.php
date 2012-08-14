<?php $this->widget('application.extensions.mbmenu.MbMenu', array(
    'items' => array(
        array('label' => 'Общие', 'active' => ((in_array(Yii::app()->controller->id, array('settings', 'messages'))) ? true : false),
            'items' => array(
                array('label' => 'Настройки', 'url' => array('/admin/settings')),
                array('label' => 'Сообщения', 'url' => array('/admin/messages')),
            ),
        ),
        array('label' => 'Пользователи', 'url' => array('/admin/user'),
            'items' => array(
                array('label' => 'Права', 'url' => array('/rights')),
            ),
        ),
        array('label' => 'Финансы', 'active' => ((in_array(Yii::app()->controller->id, array('payment'))) ? true : false),
            'items' => array(
                array('label' => 'Ввод средств', 'url' => array('/admin/payment/input')),
                array('label' => 'Баланс', 'url' => array('/admin/payment/balance')),
                array('label' => 'История', 'url' => array('/admin/payment/history')),
            ),
        ),
        array('label' => 'Модели', 'active' => ((in_array(Yii::app()->controller->id, array('page', 'city', 'category', 'subCategory'))) ? true : false),
            'items' => array(
                array('label' => 'Страницы', 'url' => array('/admin/page')),
                array('label' => 'Города', 'url' => array('/admin/city')),
                array('label' => 'Категории', 'url' => array('/admin/category')),
                array('label' => 'Подкатегории', 'url' => array('/admin/subCategory')),
            ),
        ),
        array('label' => 'Задачи', 'url' => array('/admin/tasks'), 'active' => ((in_array(Yii::app()->controller->id, array('tasks'))) ? true : false),
        ),
        array('label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest)
    ),
)); ?>