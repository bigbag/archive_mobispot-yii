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
        'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
        'title' => 'Google (OAuth)',
    ),
    'facebook' => array(
        // register your app here: https://developers.facebook.com/apps/
        'class' => 'FacebookOAuthService',
        'client_id' => '313883902043541',
        'scope' => 'email',
        'client_secret' => '6a0cc2538ecb92a57f0dbf3834ee7bd0',
    ),
);
