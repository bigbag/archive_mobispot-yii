<?php

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

class CustomFoursquareOAuthService extends EOAuth2Service
{

    protected $name = 'foursquare';
    protected $title = 'foursquare';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
    protected $client_id = '';
    protected $client_secret = '';
    protected $providerOptions = array(
        'authorize' => 'https://foursquare.com/oauth2/authenticate', //https://ru.foursquare.com/oauth2/authorize
        'access_token' => 'https://foursquare.com/oauth2/access_token',
    );

    protected function fetchAttributes()
    {
        //    $info = (array)$this->makeSignedRequest('https://api.foursquare.com/v2/users/self', array(), true);
        $token = $this->getState('auth_token')->access_token;
        $info = (object) $this->makeRequest('https://api.foursquare.com/v2/users/self?oauth_token=' . $token . '&v=20140203', array(), true);
        $info = $info->response->user;

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->id;

        if (!empty($info->firstName)) {
            $this->attributes['name'] = $info->firstName;
            $this->attributes['first_name'] = $info->firstName;
            if (!empty($info->lastName)) {
                $this->attributes['name'] = $info->firstName . ' ' . $info->lastName;
                $this->attributes['last_name'] = $info->lastName;
            }
        }

        $this->attributes['url'] = 'https://ru.foursquare.com/user/' . $info->id;
        $this->attributes['photo'] = (!empty($info->photo)) ? $info->photo : false;
        $this->attributes['email'] = (!empty($info->email)) ? $info->email : false;
        $this->attributes['auth_token'] = $this->access_token->access_token;

    }

    protected function getAccessToken($code)
    {
        $token_answer = $this->makeRequest($this->getTokenUrl($code));
        return $token_answer;
    }

    protected function getCodeUrl($redirect_uri)
    {
        $this->setState('foursquare_redirect_uri', urlencode($redirect_uri));
        $url = parent::getCodeUrl($redirect_uri) . '&v=20140203';
        return $url;
    }

    protected function getTokenUrl($code)
    {
        return $this->providerOptions['access_token'] . '?client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&grant_type=authorization_code&redirect_uri=' . $this->getState('foursquare_redirect_uri') . '&code=' . $code . '&v=20140203';
    }

}
