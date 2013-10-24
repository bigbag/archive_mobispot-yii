<?php

require_once dirname(dirname(__FILE__)).'/EOAuthService.php';

class CustomTumblrAuthService extends EOAuthService {
    
    protected $name = 'tumblr';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
            
    protected $key = '';
    protected $secret = '';
    protected $providerOptions = array(
        'request' => 'http://www.tumblr.com/oauth/request_token',
        'authorize' => 'http://www.tumblr.com/oauth/authorize',
        'access' => 'http://www.tumblr.com/oauth/access_token',
    );

    protected function fetchAttributes() 
    {
        $info = $this->makeSignedRequest('http://api.tumblr.com/v2/user/info');
        $this->attributes['id'] = $info->response->user->name;//$info->response->user->blogs[0]->url;
        $this->attributes['name'] = $info->response->user->name;
        $this->attributes['url'] = $info->response->user->blogs[0]->url;
    }
    
    /**
     * Returns the OAuth access token.
     * @return string the token.
     */
    protected function getAccessToken()
    {
        $accessToken = parent::getAccessToken();
        Yii::app()->session['tumblr_token'] = $accessToken;
        return $accessToken;
    }
}