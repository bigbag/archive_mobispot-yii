<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Mobispot',
    'theme' => 'mobispot',
    'sourceLanguage' => 'en_US',
    'language' => 'en',
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
            'useTransparentSessionID' => false,
            'autoStart' => 'false',
            'cookieMode' => 'only',
            'timeout' => 36000
        ),
        'messages' => array(
            'class' => 'CPhpMessageSource',
            'onMissingTranslation' => array('Translation', 'missing'),
            'cachingDuration'=>3600,
        ),
        'user' => array(
            'class' => 'CWebUser',
            'allowAutoLogin' => true,
        ),
        'urlManager' => require(dirname(__FILE__) . '/routes.php'),
        'ut' => include(dirname(__FILE__) . '/ut.php'),
        'db' => require(dirname(__FILE__) . '/db.php'),
        'dbStore' => require(dirname(__FILE__) . '/dbStore.php'),
        'dbTerm' => require(dirname(__FILE__) . '/dbTerm.php'),
        'dbPayment' => require(dirname(__FILE__) . '/dbPayment.php'),
        'dbStack' => require(dirname(__FILE__) . '/dbStack.php'),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'categories' => 'application*',
                    'levels' => 'error, warning, trace, profile, info',
                ),
                array(
                    'class' => 'ext.db_profiler.DbProfileLogRoute',
                    'countLimit' => 1,
                    'slowQueryMin' => 0.01,
                ),
            ),
        ),
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        'detectMobileBrowser' => array(
            'class' => 'ext.detectmobile.XDetectMobileBrowser',
        ),
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true,
            'cache' => false,
            'cacheExpire' => 0,
            'services' => require(dirname(__FILE__) . '/eauth.php'),
        ),
        'par' => array(
            'class' => 'application.extensions.dbparam.XDbParam',
            'connectionID' => 'db',
        ),
        'cache' => array(
            'class'=>'CRedisCache',
            'hostname'=>'localhost',
            'port'=>6379,
            'database'=>0,
        ),
        'hasher' => array(
            'class' => 'Phpass',
            'hashPortable' => false,
            'hashCostLog2' => 10,
        ),
    ),
    'params' => include(dirname(__FILE__) . '/params.php'),
);
