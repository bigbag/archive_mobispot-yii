<?php
return array( // You can change the providers and their classes.
    'twitter' => array(
        // register your app here: https://dev.twitter.com/apps/new
        'class' => 'TwitterOAuthService',
        'key' => 'QlnOol9mGgTn6zZXrWZOow',
        'secret' => 'J1eJFs0J4YlbaFyAvYEa4IXK0yQRV6HKxzchjN60M',
    ),

    'google_oauth' => array(
        // register your app here: https://code.google.com/apis/console/
        'class' => 'CustomGoogleOAuthService',
        'client_id' => '510457098983.apps.googleusercontent.com',
        'client_secret' => 'qGZivEcZ3icszUdhKOyW9uP3',
        'title' => 'Google (OAuth)',
    ),
    'facebook' => array(
        // register your app here: https://developers.facebook.com/apps/
        'class' => 'FacebookOAuthService',
        'client_id' => '445335612171646',
        'client_secret' => '03e2146d3f36d3feca0bed3dd7a9dea7',
    ),
);
