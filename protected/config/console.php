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
        'db' => require(dirname(__FILE__) . '/db.php'),
    ),

);