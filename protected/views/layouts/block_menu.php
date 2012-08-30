<?php $this->widget('application.extensions.mbmenu.MbMenu', array(
    'items' => array(
        array('label' => 'Общие', 'active' => ((in_array(Yii::app()->controller->id, array('settings, database'))) ? true : false),
            'items' => array(
                array('label' => 'Настройки', 'url' => array('/admin/settings/')),
                array('label' => 'База', 'url' => array('/admin/database/')),
            ),
        ),
        array('label' => 'Пользователи', 'url' => array('/admin/user/'), 'active' => ((in_array(Yii::app()->controller->id, array('user'))) ? true : false),
        ),
        array('label' => 'Содержимое', 'active' => ((in_array(Yii::app()->controller->id, array('pageCategory', 'page'))) ? true : false),
            'items' => array(
                array('label' => 'Типы страниц', 'url' => array('/admin/pageCategory/')),
                array('label' => 'Страницы', 'url' => array('/admin/page/')),
            ),
        ),
        array('label' => 'Споты', 'url' => array('/admin/spot/'), 'active' => ((in_array(Yii::app()->controller->id, array(
            'discodes', 'spot', 'spotType', 'spotHardType', 'spotField', 'spotComment'))) ? true : false),
            'items' => array(
                array('label' => 'ДИС', 'url' => array('/admin/discodes')),
                array('label' => 'Типы спотов', 'url' => array('/admin/spotType/')),
                array('label' => 'Доступные Поля', 'url' => array('/admin/spotField/')),
                array('label' => 'Типы исполнения спотов', 'url' => array('/admin/spotHardType/')),
                array('label' => 'Комментарии', 'url' => array('/admin/spotComment/')),
            ),
        ),
        array('label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => array('/user/logout'), 'visible' => !Yii::app()->user->isGuest)
    ),
)); ?>