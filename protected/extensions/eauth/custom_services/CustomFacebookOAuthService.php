<?php

/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)) . '/services/FacebookOAuthService.php';

class CustomFacebookOAuthService extends FacebookOAuthService
{

    protected function fetchAttributes()
    {
        $info = (object) $this->makeSignedRequest('https://graph.facebook.com/me');

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = (!empty($info->name)) ? $info->name : false;
        $this->attributes['photo'] = 'https://graph.facebook.com/' . $info->username . '/picture';
        $this->attributes['url'] = (!empty($info->link)) ? $info->link : 'https://www.facebook.com/' . $info->username;
        $this->attributes['email'] = (!empty($info->email)) ? $info->email : false;
        $this->attributes['expires'] = $this->getState('expires');
        $this->attributes['auth_token'] = ($this->getState('auth_token')) ? $this->getState('auth_token') : false;
        $this->attributes['auth_secret'] = false;
    }

}
