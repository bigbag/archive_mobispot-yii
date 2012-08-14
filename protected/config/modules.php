<?php
return array(

    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'runbee',
        //'ipFilters'=>array('127.0.0.1','::1'),

    ),

    'user' => array(
        // названия таблиц взяты по умолчанию, их можно изменить
        'tableUsers' => 'tbl_users',
        'tableProfiles' => 'tbl_profiles',
        'tableProfileFields' => 'tbl_profiles_fields',
        # encrypting method (php hash function)
        'hash' => 'sha1',
        # send activation email
        'sendActivationMail' => true,
        # allow access for non-activated users
        'loginNotActiv' => false,
        # activate user on registration (only sendActivationMail = false)
        'activeAfterRegister' => false,
        # automatically login from registration
        'autoLogin' => true,
        # registration path
        'registrationUrl' => array('/service/registration'),
        # recovery password path
        'recoveryUrl' => array('/service/recovery'),
        # login form path
        'loginUrl' => array('/'),
        # page after login
        'returnUrl' => array('/user/profile'),
        # page after logout
        'returnLogoutUrl' => array('/'),
    ),
    'rights'=>array(
        'authenticatedName'=>'Authenticated',
        'userIdColumn'=>'id',
        'userNameColumn'=>'username',
        'appLayout' => 'application.views.layouts.admin_main',
        'install'=>false,
        'debug'=>false,
    ),

    'admin' => array(
        'defaultController' => 'settings',
    ),
);