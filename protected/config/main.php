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
    'import' => array(
        'application.models.*',
        'application.models.form.*',
        'application.models.spot.*',
        'application.models.spot.form.*',
        'application.models.user.*',
        'application.models.user.form.*',
        'application.models.content.*',
        'application.models.content.form.*',
        'application.models.payment.*',
        'application.models.store.*',
        'application.models.term.*',
        'application.models.social.*',
        'application.models.social.soc_content.*',
        'application.components.*',
        'application.helpers.*',
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
        'ext.eauth.custom_services.*',
        'application.extensions.phpass.*',
        'application.extensions.image.*',
    ),
    'modules' => array(
        'mobile' => array(
            'defaultController' => 'user',
        ),
        'store' => array(
            'defaultController' => 'product',
        ),
        'corp' => array(
            'defaultController' => 'site',
        ),
    ),
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
            'cookieParams' => array('domain' => '.mobispot.test'),
            'timeout' => 36000
        ),
        'request' => array(
            'csrfCookie' => array(
                'domain' => '.mobispot.test',
            ),
        ),
        'messages' => array(
            'class' => 'CPhpMessageSource',
            'onMissingTranslation' => array('Translation', 'missing'),
            'cachingDuration' => 3600,
        ),
        'user' => array(
            'class' => 'CWebUser',
            'allowAutoLogin' => true,
        ),
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=mobispot',
            'username' => 'user',
            'password' => 'password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'dbStore' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=store',
            'username' => 'user',
            'password' => 'password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'dbTerm' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=term',
            'username' => 'user',
            'password' => 'password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'dbPayment' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=payment',
            'username' => 'user',
            'password' => 'password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'dbStack' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=stack',
            'username' => 'user',
            'password' => 'password',
            'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
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
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true,
            'cache' => false,
            'cacheExpire' => 0,
            'services' => require(dirname(__FILE__) . '/eauth.php'),
        ),
        'cache' => array(
            'class' => 'CRedisCache',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ),
        'hasher' => array(
            'class' => 'Phpass',
            'hashPortable' => false,
            'hashCostLog2' => 10,
        ),
        'urlManager' => require(dirname(__FILE__) . '/routes.php'),
    ),
    'params' => include(dirname(__FILE__) . '/params.php'),
);
