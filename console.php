<?php

$yii=dirname(__FILE__).'/yii/yii.php';
$config=dirname(__FILE__).'/protected/config/console.php';

defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createConsoleApplication($config)->run();
?>