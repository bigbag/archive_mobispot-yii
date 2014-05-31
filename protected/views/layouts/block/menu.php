<?php

$this->widget('application.extensions.mbmenu.MbMenu', array(
    'items' => array(
        array('label' => 'Общие', 'active' => ((in_array(Yii::app()->controller->id, array('settings', 'database'))) ? true : false),
            'items' => array(
                array('label' => 'Настройки', 'url' => array('/admin/settings/')),
            ),
        ),
        array('label' => 'Пользователи', 'url' => array('/admin/user/'), 'active' => ((in_array(Yii::app()->controller->id, array('user'))) ? true : false),
        ),
        array('label' => 'Содержимое', 'active' => ((in_array(Yii::app()->controller->id, array('pageCategory', 'contentFaq', 'pageTemplate', 'contentBannerFooter', 'contentCarousel', 'contentLinksFooter'))) ? true : false),
            'items' => array(
                array('label' => 'Переводы', 'url' => array('/admin/translation/')),
                array('label' => 'Страницы', 'url' => array('/admin/page/')),
                array('label' => 'FAQ', 'url' => array('/admin/contentFaq/')),
         ),
        ),
        array('label' => 'Почта', 'active' => ((in_array(Yii::app()->controller->id, array('mailEvent', 'mailTemplate'))) ? true : false),
            'items' => array(
                array('label' => 'Шаблоны', 'url' => array('/admin/mailTemplate/')),
            ),
        ),
        array('label' => 'Споты', 'url' => array('/admin/spot/'), 'active' => ((in_array(Yii::app()->controller->id, array(
                'discodes', 'spot', 'spotHardType', 'spotPersonalField', 'spotComment'))) ? true : false),
            'items' => array(
                array('label' => 'ID', 'url' => array('/admin/discodes')),
                array('label' => 'Типы исполнения спотов', 'url' => array('/admin/spotHardType/')),
                array('label' => 'Комментарии', 'url' => array('/admin/spotComment/')),
            ),
        ),
        array('label' => 'Выйти (' . Yii::app()->user->name . ')', 'url' => array('/service/logout'), 'visible' => !Yii::app()->user->isGuest)
    ),
));
