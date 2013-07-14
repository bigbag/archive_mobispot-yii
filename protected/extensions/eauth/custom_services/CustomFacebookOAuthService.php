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
        $info = (object)$this->makeSignedRequest('https://graph.facebook.com/me');

        $this->attributes['id'] = $info->id;
        $this->attributes['photo'] = 'http://graph.facebook.com/'.$info->username.'/picture';
        if(!empty($info->name))
            $this->attributes['name'] = $info->name;
        if(!empty($info->link))
            $this->attributes['url'] = $info->link;
        if(!empty($info->email))
            $this->attributes['email'] = $info->email;

        if ($this->hasState('auth_token'))
        {
            $socToken=SocToken::model()->findByAttributes(array(
                'user_id'=>Yii::app()->user->id,
                'type'=>1,
            ));
            if(!$socToken)
                $socToken = new SocToken;
            $socToken->type = 1;
            $socToken->user_id = Yii::app()->user->id;
            $socToken->user_token = $this->getState('auth_token');
            if ($this->hasState('expires'))
                $socToken->token_expires = $this->getState('expires');
            $socToken->save();
        }
    /*
    if(!empty($info->locale))  
      $this->attributes['language'] = $info->locale == 'ru_RU' ? 'ru' : $info->locale;
    if(!empty($info->timezone))
      $this->attributes['timezone'] = $info->timezone == 4 ? 'Moscow(UTC+4)' : $info->timezone;
    if (!empty($info->gender))
      $this->attributes['gender'] = $info->gender;
    Yii::app()->session['facebook_token'] = $this->getState('auth_token');
    */
    }
}