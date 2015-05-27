<?php

/**
 * LinkedinOAuthService class file.
 *
 * Register application: https://www.linkedin.com/secure/developer
 * Note: Intagration URL should be filled with a valid callback url.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';
require_once dirname(__FILE__) . '/CustomEOAuthUserIdentity.php';

/**
 * LinkedIn provider class.
 * @package application.extensions.eauth.services
 */
class CustomLinkedinOAuthService extends EOAuth2Service
{

    protected $name = 'linkedin';
    protected $title = 'LinkedIn';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
    protected $key = '';
    protected $secret = '';
    protected $state = '';
    protected $client_id = '';
    protected $client_secret = '';
    protected $providerOptions = array(
        'authorize' => 'https://www.linkedin.com/uas/oauth2/authorization',
        'access_token' => 'https://www.linkedin.com/uas/oauth2/accessToken',
    );

    protected function fetchAttributes()
    {

        $info = $this->makeSignedRequest(LinkedInContent::URL_PROFILE);

        $this->attributes['id'] = $info['id'];
        $this->attributes['name'] = $info['firstName'] . ' ' . $info['lastName'];
        if (!empty($info['siteStandardProfileRequest']) and !empty($info['siteStandardProfileRequest']['url'])){
            $this->attributes['url'] = LinkedInContent::filterPublicUrl($info['siteStandardProfileRequest']['url']);
        } else {
            $this->attributes['url'] = false;
        }
        $this->attributes['photo'] = (!empty($info['pictureUrl'])) ? $info['pictureUrl'] : false;
        $this->attributes['expires'] = $this->getState('expires');
        $this->attributes['auth_token'] = $this->access_token;
    }

    /**
     * Returns the url to request to get OAuth2 code.
     *
     * @param string $redirect_uri url to redirect after user confirmation.
     * @return string url to request.
     */
    protected function getCodeUrl($redirect_uri)
    {
        $this->setState('redirect_uri', $redirect_uri);
        return $this->providerOptions['authorize'] 
                . '?response_type=code'
                . '&client_id=' . $this->client_id 
                . '&redirect_uri=' . urlencode($redirect_uri) 
                . '&scope=' . $this->scope
                . '&state=' . Yii::app()->request->csrfToken;
    }
    
    /**
     * Returns the url to request to get OAuth2 access token.
     *
     * @param string $code
     * @return string url to request.
     */
    protected function getTokenUrl($code)
    {
        return $this->providerOptions['access_token'] 
            . '?grant_type=authorization_code'
            . '&client_id=' . $this->client_id 
            . '&client_secret=' . $this->client_secret 
            . '&code=' . $code 
            . '&redirect_uri=' . urlencode($this->getState('redirect_uri'));
    }
    
     /**
     * Save access token to the session.
     *
     * @param string $token access token.
     */
    protected function saveAccessToken($token)
    {
        $this->setState('auth_token', $token->access_token);
        $this->setState('expires', isset($token->expires_in) ? time() + (int)$token->expires_in - 60 : 0);
        $this->access_token = $token->access_token;
    }

    /**
     * Returns the protected resource.
     *
     * @param string $url url to request.
     * @param array $options HTTP request options. Keys: query, data, referer.
     * @param boolean $parseJson Whether to parse response in json format.
     * @return stdClass the response.
     * @see makeRequest
     */
    public function makeSignedRequest($url, $options = array(), $parseJson = true)
    {
        $ch = $this->initRequest($url, $options);
        $auth_header = 'Authorization: Bearer ' . $this->access_token;
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($auth_header));

        $result = curl_exec($ch);
        $headers = curl_getinfo($ch);

        if (curl_errno($ch) > 0) {
            throw new EAuthException(curl_error($ch), curl_errno($ch));
        }

        if ($headers['http_code'] != 200) {
            Yii::log(
                'Invalid response http code: ' . $headers['http_code'] . '.' . PHP_EOL .
                    'URL: ' . $url . PHP_EOL .
                    'Options: ' . var_export($options, true) . PHP_EOL .
                    'Result: ' . $result,
                CLogger::LEVEL_ERROR, 'application.extensions.eauth'
            );
            throw new EAuthException(Yii::t('eauth', 'Invalid response http code: {code}.', array('{code}' => $headers['http_code'])), $headers['http_code']);
        }

        curl_close($ch);

        if ($parseJson) {
            $result = CJSON::decode($result, true);
        }

        return $result;
    }
    
}
