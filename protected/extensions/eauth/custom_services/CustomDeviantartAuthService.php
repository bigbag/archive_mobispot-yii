<?php

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

class CustomDeviantartAuthService extends EOAuth2Service
{

    protected $name = 'deviantart';
    protected $title = 'DeviantART';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
    protected $client_id = '';
    protected $client_secret = '';
    protected $providerOptions = array(
        'authorize' => 'https://www.deviantart.com/oauth2/draft15/authorize',
        'access_token' => 'https://www.deviantart.com/oauth2/draft15/token',
    );

    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('https://www.deviantart.com/api/draft15/user/whoami');
        //$info = $this->makeSignedRequest('https://www.deviantart.com/api/draft15/placebo');
        $this->attributes['id'] = $info->username;
        $this->attributes['name'] = $info->username;
        $this->attributes['url'] = 'http://' . $info->username . '.deviantart.com';
        if (!empty($info->usericonurl))
            $this->attributes['photo'] = $info->usericonurl;
        /*
          $options=array();
          $userLent = $this->makeRequest('http://backend.deviantart.com/rss.xml?q=by%3A'.$info->username.'+sort%3Atime+meta%3Aall', $options, false);
          $xml = new SimpleXMLElement($userLent);
         */
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
            $code = $_GET['code'] . '&grant_type=authorization_code';
            $token = $this->getAccessToken($code);
            if (isset($token)) {
                $this->saveAccessToken($token);
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
            Yii::app()->request->redirect($url);
        }

        return $this->getIsAuthenticated();
    }

    public function makeSignedRequest($url, $options = array(), $parseJson = true)
    {
        if (!$this->getIsAuthenticated())
            throw new CHttpException(401, Yii::t('eauth', 'Unable to complete the request because the user was not authenticated.'));

        $options['query']['access_token'] = $this->access_token->access_token;
        $result = $this->makeRequest($url, $options);
        return $result;
    }

}
