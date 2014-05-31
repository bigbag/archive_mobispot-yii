<?php

require_once dirname(dirname(__FILE__)) . '/EOAuthService.php';

class CustomFlickrAuthService extends EOAuthService
{

    protected $name = 'flickr';
    protected $title = 'Flickr';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
    protected $key = '';
    protected $secret = '';
    protected $scope = '';
    protected $providerOptions = array(
        'request' => 'http://www.flickr.com/services/oauth/request_token',
        'authorize' => 'http://www.flickr.com/services/oauth/authorize',
        'access' => 'http://www.flickr.com/services/oauth/access_token',
    );
    private $auth;

    protected function fetchAttributes()
    {
        $this->attributes['id'] = 'id';
        $this->attributes['name'] = 'username';
    }

    public function init($component, $options = array())
    {
        parent::init($component, $options);
        //'oauth_nonce'=>'95613465',
        //'oauth_timestamp' => time(),
        //'oauth_consumer_key' => $this->key,
        //'oauth_signature_method'=>'HMAC-SHA1',
        //'oauth_version'=>'1.0',
        $this->auth = new EOAuthUserIdentity(array(
            'scope' => $this->scope,
            'key' => $this->key,
            'secret' => $this->secret,
            'provider' => $this->providerOptions,
        ));
    }

    /**
     * Authenticate the user.
     * @return boolean whether user was successfuly authenticated.
     */
    public function authenticate()
    {
        $this->authenticated = $this->auth->authenticate();
        return $this->getIsAuthenticated();
    }

}
