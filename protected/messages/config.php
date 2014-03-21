<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
        'sourcePath'=>dirname(__FILE__) . '/../../',
        'messagePath'=>dirname(__FILE__),
        'languages'=>array('ru','en', 'zh_cn', 'zh_tw'),
        'fileTypes'=>array('php'),
        'overwrite'=>true,
        'sort'=>true,
        'exclude'=>array(
                '.svn',
                '.gitignore',
                'yiilite.php',
                'yiit.php',
                '/i18n/data',
                '/messages',
                '/vendors',
                '/web/js',
                '/yii',
                '/themes/mobile/images/',
                '/modules/corp'
        ),
);