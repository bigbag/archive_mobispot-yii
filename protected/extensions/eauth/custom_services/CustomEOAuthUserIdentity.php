<?php

/*
 * This product includes software developed at
 * Google Inc. (http://www.google.es/about.html)
 * under Apache 2.0 License (http://www.apache.org/licenses/LICENSE-2.0.html).
 *
 * See http://google-api-dfp-php.googlecode.com.
 *
 */

class CustomEOAuthUserIdentity extends EOAuthComponent implements IUserIdentity
{

    /**
     * @var string (required)
     * For example 'https://sandbox.google.com/apis/ads/publisher/'
     */
    public $scope;

    /**
     * @var string OAuth consumer key. Defaults to 'anonymous'
     */
    public $key = 'anonymous';

    /**
     * @var string OAuth consumer secret. Defaults to 'anonymous'
     */
    public $secret = 'anonymous';
    public $token_expires;

    /**
     * @var array|class OAuthProvider configuration|class.
     * If using array:
     *      'provider'=>array(
     *          'request'=>'https://www...',
     *          'authorize'=>'https://www...',
     *          'access'=>'https://www...',
     *      )
     *
     * @see EOAuthProvider
     */
    protected $provider;
    protected $_providerClass = 'EOAuthProvider';
    protected $_authenticated = false;
    protected $_error;

    public function __construct($attributes)
    {

        if (is_array($attributes)) {
            if (isset($attributes['provider'])) {
                $this->setProvider($attributes['provider']);
                unset($attributes['provider']);
            } else
                $this->setProvider();

            foreach ($attributes as $attr => $value)
                $this->$attr = $value;
        } else
            return null;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function setError($msg)
    {
        $this->_error = $msg;
    }

    public function getIsAuthenticated()
    {
        return $this->_authenticated;
    }

    public function getId()
    {
        return $this->provider->token->key;
    }

    public function getName()
    {
        return $this->provider->token->key;
    }

    public function getPersistentStates()
    {

    }

    public function authenticate()
    {

        $session = Yii::app()->session;

        if (isset($_REQUEST['oauth_token'])) {
            $oauthToken = $_REQUEST['oauth_token'];
        }
        if (isset($_REQUEST['oauth_verifier'])) {
            $oauthVerifier = $_REQUEST['oauth_verifier'];
        }

        try {

            if (!isset($oauthToken)) {
                // Create consumer.
                $consumer = new OAuthConsumer($this->key, $this->secret);

                // Set the scope (must match service endpoint).
                $scope = $this->scope;

                // Set the application name as it is displayed on the authorization page.
                $applicationName = Yii::app()->name;

                // Use the URL of the current page as the callback URL.
                $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https://' : 'http://';
                $server = $_SERVER['HTTP_HOST'];
                $path = $_SERVER["REQUEST_URI"];
                $callbackUrl = $protocol . $server . $path;

                // Get request token.
                $token = EOAuthUtils::GetRequestToken($consumer, $scope, $this->provider->request_token_endpoint, $applicationName, $callbackUrl);

                // Store consumer and token in session.
                $session['OAUTH_CONSUMER'] = $consumer;
                $session['OAUTH_TOKEN'] = $token;

                // Get authorization URL.
                $url = EOAuthUtils::GetAuthorizationUrl($token, $this->provider->authorize_token_endpoint);

                // Redirect to authorization URL.
                Yii::app()->request->redirect($url);
            } else {
                // Retrieve consumer and token from session.
                $consumer = $session['OAUTH_CONSUMER'];
                $token = $session['OAUTH_TOKEN'];

                // Set authorized token.
                $token->key = $oauthToken;

                // Upgrade to access token.
                $token = $this->GetAccessToken($consumer, $token, $oauthVerifier, $this->provider->access_token_endpoint);

                // Set OAuth provider.
                $this->provider->consumer = $consumer;
                $this->provider->token = $token;

                $this->_authenticated = true;
            }
        } catch (OAuthException $e) {
            $this->_error = $e->getMessage();
        }

        return $this->isAuthenticated;
    }

    public function setProvider($provider = 'EOAuthProvider')
    {
        if (is_string($provider))
            $this->_providerClass = $provider;
        $this->provider = new $this->_providerClass;
        if (is_array($provider))
            foreach ($provider as $attr => $val) {
                $attribute = $attr . '_token_endpoint';
                $this->provider->$attribute = $val;
            }
    }

    public function getProvider()
    {
        return $this->provider;
    }

    protected function GetAccessToken(OAuthConsumer $consumer, OAuthToken $token, $verifier, $endpoint)
    {
        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();

        // Set parameters.
        $params = array();
        $params['oauth_verifier'] = $verifier;

        // Create and sign request.
        $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $endpoint, $params);
        $request->sign_request($signatureMethod, $consumer, $token);

        // Get token.
        return $this->GetTokenFromUrl($request->to_url());
    }

    protected function GetTokenFromUrl($url)
    {
        $ch = curl_init($url);
        #curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        $headers = curl_getinfo($ch);
        curl_close($ch);

        if ($headers['http_code'] != 200) {
            throw new OAuthException($response);
        }
        return $this->GetTokenFromQueryString($response);
    }

    protected function GetTokenFromQueryString($queryString)
    {
        $values = array();
        parse_str($queryString, $values);
        if (!empty($values['oauth_expires_in'])) {
            $this->token_expires = $values['oauth_expires_in'];
            if (!empty($values['oauth_authorization_expires_in']) && ($values['oauth_authorization_expires_in'] < $values['oauth_expires_in']))
                $this->token_expires = $values['oauth_authorization_expires_in'];
        }
        return new OAuthToken($values['oauth_token'], $values['oauth_token_secret']);
    }

}
