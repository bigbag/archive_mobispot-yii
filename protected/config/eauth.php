<?php
return array( // You can change the providers and their classes.
    'twitter' => array(
        // register your app here: https://dev.twitter.com/apps/new
        'class' => 'TwitterOAuthService',
        'key' => 'eX4XJnsIVOpXwNlo8xIxQ',
        'secret' => 'Z3jH7SAFzc8bRNXaif8rLSKZcA17lSYC9AjW9qJwO0',
    ),

    'google_oauth' => array(
        // register your app here: https://code.google.com/apis/console/
        'class' => 'CustomGoogleOAuthService',
        'client_id' => '419796517496.apps.googleusercontent.com',
        'client_secret' => '25pDyrLThDlGaKxCf3UtnXU_',
        'title' => 'Google (OAuth)',
    ),
    'facebook' => array(
        // register your app here: https://developers.facebook.com/apps/
        'class' => 'FacebookOAuthService',
        'client_id' => '219110061545862',
        'client_secret' => 'dc8e6d5bb095853fe53dd2bfd63a92da',
    ),
);
