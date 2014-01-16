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

        $this->attributes['id'] = $info->id;
        $this->attributes['name'] = $info->name;
        //$this->attributes['url'] = 'http://twitter.com/account/redirect_by_id?id='.$info->id_str;
        $this->attributes['url'] = 'https://twitter.com/' . $info->screen_name;
        
/*
        $this->attributes['username'] = $info->name;
        $this->attributes['language'] = $info->lang;
        $this->attributes['timezone'] = timezone_name_from_abbr('', $info->utc_offset, date('I')); 
        $this->attributes['photo'] = $info->profile_image_url;
        $this->attributes['user_site'] = $info->url;
        $this->attributes['location'] = $info->location;
        $this->attributes['about'] = $info->description;
        $this->attributes['last_status'] = $info->status->text;
*/
        
//$this->attributes['info'] = $info;        
        if ($this->hasState('twitter_oauth_token') && !Yii::app()->user->isGuest)
        {
            $socToken=SocToken::model()->findByAttributes(array(
                'user_id'=>Yii::app()->user->id,
                'type'=>SocToken::TYPE_TWITTER,
            ));
            if(!$socToken)
                $socToken = new SocToken;
            $socToken->type = SocToken::TYPE_TWITTER;
            $socToken->user_id = Yii::app()->user->id;
            $socToken->soc_id = $info->id;
            $tokenAndSecret = TwitterContent::ParseOAuthToken($this->getState('twitter_oauth_token'));
            $socToken->user_token = $tokenAndSecret['token'];
            $socToken->token_secret = $tokenAndSecret['secret'];
            //if ($this->hasState('expires'))
            //    $socToken->token_expires = $this->getState('expires');
            $socToken->save();
        }
    }
    
    protected function getAccessToken()
    {
        $token = parent::getAccessToken();
        $this->setState('twitter_oauth_token', $token);
        return $token;
    }
}