<?php

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

class CustomInstagramOAuthService extends EOAuth2Service
{

    protected $name = 'instagram';
    protected $title = 'Instagram';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 500, 'height' => 450));
    protected $client_id = '';
    protected $client_secret = '';
    protected $scope = 'basic';
    protected $providerOptions = array(
        'authorize' => 'https://api.instagram.com/oauth/authorize/',
        'access_token' => 'https://api.instagram.com/oauth/access_token',
    );

    protected function fetchAttributes()
    {
        $this->attributes['id'] = $this->getState('instagram_id');
        $this->attributes['name'] = $this->getState('instagram_username');
        $this->attributes['url'] = 'http://instagram.com/' . $this->getState('instagram_username');
        $this->attributes['expires'] = $this->getState('expires');
        $this->attributes['auth_token'] = ($this->getState('auth_token')) ? $this->getState('auth_token') : false;
    }

    protected function getCodeUrl($redirect_uri)
    {
        $url = parent::getCodeUrl($redirect_uri);
        if (strpos($url, urlencode('&return_url=')) !== false) {
            $suffix = substr($url, (strpos($url, urlencode('&return_url='))));
            $url = substr($url, 0, (strpos($url, urlencode('&return_url='))));
            $returnUrl = substr($suffix, (strpos($url, urlencode('&return_url=')) + strlen(urlencode('&return_url='))));
            if (strpos($suffix, '&') !== false) {
                $suffix = substr($suffix, strpos($suffix, '&'));
                $url .= $suffix;
                $returnUrl = substr($returnUrl, 0, strpos($returnUrl, '&'));
            }
            $returnUrl = str_replace('www.', '', $returnUrl);
            Yii::app()->session['returnUrl'] = urldecode(urldecode($returnUrl));
        }
        $url = str_replace('www.', '', $url);
        $this->setState('instagram_redirect_uri', $url);
        return $url;
    }

    protected function getTokenUrl($code)
    {
        return $this->providerOptions['access_token'];
    }

    protected function getAccessToken($code)
    {
        return $this->makeRequest($this->getTokenUrl($code), array('data' => 'client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&grant_type=authorization_code&redirect_uri=' . $this->getState('instagram_redirect_uri') . '&code=' . $code));
    }

    protected function saveAccessToken($token)
    {
        $this->setState('auth_token', $token->access_token);
        Yii::app()->session['instagram_token'] = $token->access_token;
        $this->setState('instagram_id', $token->user->id);
        $this->setState('instagram_username', $token->user->username);
        $this->access_token = $token->access_token;
    }

}
