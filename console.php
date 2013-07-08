<?php

date_default_timezone_set("Europe/Moscow");
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
mb_http_input('UTF-8');
mb_http_output('UTF-8');
setlocale(LC_ALL, 'ru_RU.UTF-8');
setlocale(LC_NUMERIC, 'en_US.UTF-8');

// change the following paths if necessary
$yii = dirname(__FILE__) . './../yii/yiilite.php';
$config = dirname(__FILE__) . '/protected/config/console.php';

defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once($yii);
Yii::createConsoleApplication($config)->run();
?>