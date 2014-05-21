<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Mobispot',
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.mailer.EMailer',
    ),
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=mobispot',
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
    ),
);
