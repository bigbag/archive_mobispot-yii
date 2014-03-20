<?php

/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)) . '/services/GoogleOAuthService.php';

class CustomGoogleOAuthService extends GoogleOAuthService
{

    protected $key = '';

    protected function fetchAttributes()
    {
        $info = (object) $this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');

        var_dump($info);

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = (!empty($info->name)) ? $info->name : false;
        $this->attributes['photo'] = (!empty($info->picture)) ? $info->picture : false;
        $this->attributes['url'] = (!empty($info->link)) ? $info->link : false;
        $this->attributes['email'] = (!empty($info->email)) ? $info->email : false;
        $this->attributes['expires'] = $this->getState('expires');
        $this->attributes['auth_token'] = $this->getState('auth_token');
        $this->attributes['auth_secret'] = false;
        $this->attributes['refresh_token'] = ($this->getState('refresh_token')) ? $this->getState('auth_token') : false;

    }

    protected function getCodeUrl($redirect_uri)
    {
        $this->setState('redirect_uri', $redirect_uri);
        $url = parent::getCodeUrl($redirect_uri);
        if (isset($_GET['js']) and !strpos($url, 'display=popup'))
            $url .= '&display=popup';

        $url .= '&access_type=offline';

        if (Yii::app()->user->isGuest)
        {
            $url .= '&approval_prompt=force';
            return $url;
        }

        $socToken = SocToken::model()->findByAttributes(
                array(
                    'user_id' => Yii::app()->user->id,
                    'type' => SocToken::TYPE_GOOGLE,
                )
        );

        if (!$socToken or !$socToken->refresh_token)
            $url .= '&approval_prompt=force';
        return $url;
    }

    protected function saveAccessToken($token)
    {
        $this->setState('refresh_token', $token->refresh_token);
        $this->setState('auth_token', $token->access_token);
        $this->setState('expires', time() + $token->expires_in - 60);
        $this->access_token = $token->access_token;

        parent::saveAccessToken($token);
    }

}
