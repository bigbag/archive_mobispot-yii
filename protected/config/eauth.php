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
        'client_id' => 'bilbo.kem@gmail.com',
        'client_secret' => 'AIzaSyDzzzMZPCl8lbOO-jdVCoP5QiS7dVhL4eI',
        'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
        'title' => 'Google (OAuth)',
    ),
    'facebook' => array(
        // register your app here: https://developers.facebook.com/apps/
        'class' => 'FacebookOAuthService',
        'client_id' => '472011422832770',
        'scope' => 'email',
        'client_secret' => '00952f4e8282368025d8f4a04cd38a4e',
    ),
);
