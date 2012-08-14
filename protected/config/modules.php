<?php
return array(

    'gii' => array(
        'class' => 'system.gii.GiiModule',
        'password' => 'mobispot',
        'ipFilters'=>array('127.0.0.1','::1'),
        'generatorPaths'=>array(
            'ext.mongo.gii'
        ),

    ),

    'admin' => array(
        'defaultController' => 'settings',
    ),
);