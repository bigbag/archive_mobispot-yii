<?php

/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)) . '/services/TwitterOAuthService.php';

class CustomTwitterService extends TwitterOAuthService
{

    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('https://api.twitter.com/1.1/account/verify_credentials.json');
        $tokenAndSecret = TwitterContent::ParseOAuthToken($this->getState('twitter_oauth_token'));

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->screen_name;
        $this->attributes['photo'] = (!empty($info->profile_image_url)) ? $info->profile_image_url : false;
        $this->attributes['url'] = 'https://twitter.com/' . $info->screen_name;
        $this->attributes['email'] = (!empty($info->email)) ? $info->email : false;
        $this->attributes['expires'] = time() + 60 * 60 * 24 * 100;
        $this->attributes['auth_token'] = (isset($tokenAndSecret['token'])) ? $tokenAndSecret['token'] : false;
        $this->attributes['auth_secret'] = (isset($tokenAndSecret['secret'])) ? $tokenAndSecret['secret'] : false;
    }

    protected function getAccessToken()
    {
        $token = parent::getAccessToken();
        $this->setState('twitter_oauth_token', $token);
        return $token;
    }

}
