<?php

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

class CustomBehanceAuthService extends EOAuth2Service
{

    protected $name = 'behance';
    protected $title = 'Behance';
    protected $type = 'OAuth';
    protected $scope = 'activity_read|collection_read|wip_read|project_read';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
    protected $client_id = '';
    protected $client_secret = '';
    protected $providerOptions = array(
        'authorize' => 'https://www.behance.net/v2/oauth/authenticate',
        'access_token' => 'https://www.behance.net/v2/oauth/token',
    );

    protected function fetchAttributes()
    {
        $idUser = $this->getState('idUser');

        $info = $this->makeRequest('http://www.behance.net/v2/users/' . $idUser . '?api_key=' . $this->client_id, $options, false);
        $info = CJson::decode($info, true);
        $info = $info['user'];

        $this->attributes['id'] = $info['id'];
        $this->attributes['name'] = (isset($info['username'])) ? $info['username'] : false;
        $this->attributes['photo'] = $info['images']['50'];
        $this->attributes['url'] = (!empty($info->link)) ? $info->link : 'https://www.facebook.com/' . $info->username;
        $this->attributes['email'] = (!empty($info->email)) ? $info->email : false;
        $this->attributes['expires'] = $this->getState('expires');
        $this->attributes['auth_token'] = ($this->getState('auth_token')) ? $this->getState('auth_token') : false;
    }

    public function authenticate()
    {
        // user denied error
        if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
            $this->cancel();
            return false;
        }

        // Get the access_token and save them to the session.
        if (isset($_GET['code'])) {
            $code = $_GET['code'];
            $options = array();
            $options['data'] = 'client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&code=' . $code . '&redirect_uri=' . urlencode($this->getState('redirect_uri')) . '&grant_type=authorization_code';
            $token_url = $this->providerOptions['access_token'] . '?client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&code=' . $code . '&redirect_uri=' . urlencode($this->getState('redirect_uri')) . '&grant_type=authorization_code';
            //$token = $this->makeRequest($token_url);
            $token = $this->makeRequest($this->providerOptions['access_token'], $options, true);
            if (isset($token)) {
                $this->saveAccessToken($token->access_token);
                $this->setState('idUser', $token->user->id);
                $this->authenticated = true;
            }
        }
        // Redirect to the authorization page
        else if (!$this->restoreAccessToken()) {
            // Use the URL of the current page as the callback URL.
            if (isset($_GET['redirect_uri'])) {
                $redirect_uri = $_GET['redirect_uri'];
            } else {
                $server = Yii::app()->request->getHostInfo();
                $path = Yii::app()->request->getUrl();
                $redirect_uri = $server . $path;
            }
            $url = $this->getCodeUrl($redirect_uri);
            $url = $url . '&state=state';
            Yii::app()->request->redirect($url);
        }

        return $this->getIsAuthenticated();
    }

}
