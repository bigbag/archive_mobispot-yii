<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Mobispot',
    'theme' => 'mobispot',
    'language' => 'ru',
    'charset' => 'UTF-8',
    'preload' => array('log'),
    'import' => require(dirname(__FILE__) . '/import.php'),
    'modules' => require(dirname(__FILE__) . '/modules.php'),

    // application components
    'components' => array(
        'session' => array(
            'sessionName' => 'mobispot',
            'class' => 'CDbHttpSession',
            'connectionID' => 'db',
            'sessionTableName' => 'session',
            'useTransparentSessionID' => ($_POST['PHPSESSID']) ? true : false,
            'autoStart' => 'false',
            'cookieMode' => 'only',
            'timeout' => 3600
        ),

        'messages' => array(

            'class' => 'CPhpMessageSource',
            'cachingDuration' => 3600,

        ),
        'user' => array(
            'class' => 'CWebUser',
            'allowAutoLogin' => true,
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName' => 'mobispot',
            'fsyncFlag' => false,
            'safeFlag' => false,
            'useCursor' => false,
        ),

        'urlManager' => require(dirname(__FILE__) . '/routes.php'),
        'db' => require(dirname(__FILE__) . '/db.php'),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace',
                    'categories' => 'vardump',
                    'showInFireBug' => true
                ),
                array(
                    'class' => 'CFileLogRoute',
                    'categories' => 'application',
                    'levels' => 'error, warning, trace, profile, info',
                ),
                //array(
                //    'class' => 'ext.db_profiler.DbProfileLogRoute',
                //    'countLimit' => 1,
                //    'slowQueryMin' => 0.01,
                //),
            ),
        ),
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'services' => require(dirname(__FILE__) . '/eauth.php'),
        ),
        'par' => array(
            'class' => 'application.extensions.dbparam.XDbParam',
            'connectionID' => 'db',
        ),
        'cache' => array(
            'class' => 'system.caching.CApcCache',
        ),
        'hasher' => array(
            'class' => 'Phpass',
            'hashPortable' => false,
            'hashCostLog2' => 10,
        ),
    ),
    'params' => include(dirname(__FILE__) . '/params.php'),
);