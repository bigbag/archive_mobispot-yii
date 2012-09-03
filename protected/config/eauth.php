<?php
return array( // You can change the providers and their classes.
    'twitter' => array(
        // register your app here: https://dev.twitter.com/apps/new
        'class' => 'TwitterOAuthService',
        'key' => 'VkQWh3ZxgLyiqUHaPnabmg',
        'secret' => 'cBfZQlyB0mpCaBd4g7EMT39d8apCAMbhnKGyqBXUefQ',
    ),
    'google_oauth' => array(
        // register your app here: https://code.google.com/apis/console/
        'class' => 'CustomGoogleOAuthService',
        'client_id' => '419796517496.apps.googleusercontent.com',
        'client_secret' => '25pDyrLThDlGaKxCf3UtnXU_',
        'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
        'title' => 'Google (OAuth)',
    ),
    'facebook' => array(
        // register your app here: https://developers.facebook.com/apps/
        'class' => 'CustomFacebookOAuthService',
        'scope' => 'email',
        'client_id' => '140494639427206',
        'client_secret' => 'c9b670a2463410131fd49ec4e217da89',
    ),
);
