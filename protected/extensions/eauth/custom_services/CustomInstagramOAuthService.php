<?php

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

class CustomInstagramOAuthService extends EOAuth2Service
{

    protected $name = 'instagram';
    protected $title = 'Instagram';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 500, 'height' => 450));
    protected $client_id = '';
    protected $client_secret = '';
    protected $scope = 'basic';
    protected $providerOptions = array(
        'authorize' => 'https://api.instagram.com/oauth/authorize/',
        'access_token' => 'https://api.instagram.com/oauth/access_token',
    );

    protected function fetchAttributes()
    {
        $this->attributes['id'] = $this->getState('instagram_id');
        $this->attributes['name'] = $this->getState('instagram_username');
        $this->attributes['url'] = 'http://instagram.com/' . $this->getState('instagram_username');
        /*
          $media = $this->makeSignedRequest('https://api.instagram.com/v1/users/'.$this->attributes['id'].'/media/recent');

          if(isset($media->data) && isset($media->data[0]) && !empty($media->data[0]->id) && !isset(Yii::app()->session['instagram_tech'])){
          $userSoc=UserSoc::model()->findByAttributes(array(
          'user_id'=>Yii::app()->user->id,
          'type'=>10
          ));
          if($userSoc)
          $userSoc->data = array('media_id', $media->data[0]->id);
          $userSoc->save();
          }
         */
        if (isset(Yii::app()->session['instagram_tech']))
        {
            unset(Yii::app()->session['instagram_tech']);
        }
        /*
          $info = $this->makeSignedRequest('https://api.instagram.com/v1/users/self');
          $info = $info->data;
          if(!empty($info->username))
          $this->attributes['url'] = 'http://instagram.com/'.$info->username;
          if(!empty($info->full_name))
          $this->attributes['username'] = $info->full_name;
          elseif(!empty($info->username))
          $this->attributes['username'] = $info->username;
          $this->attributes['url'] = 'http://instagram.com/'.$info->username;
          $this->attributes['photo'] = $info->profile_picture;
          if(!empty($info->bio))
          $this->attributes['about'] = $info->bio;
          if(!empty($info->website))
          $this->attributes['url'] = $info->website;
         */
    }

    protected function getCodeUrl($redirect_uri)
    {
        $url = parent::getCodeUrl($redirect_uri);
        if (strpos($url, urlencode('&return_url=')) !== false)
        {
            $suffix = substr($url, (strpos($url, urlencode('&return_url='))));
            $url = substr($url, 0, (strpos($url, urlencode('&return_url='))));
            $returnUrl = substr($suffix, (strpos($url, urlencode('&return_url=')) + strlen(urlencode('&return_url='))));
            if (strpos($suffix, '&') !== false)
            {
                $suffix = substr($suffix, strpos($suffix, '&'));
                $url .= $suffix;
                $returnUrl = substr($returnUrl, 0, strpos($returnUrl, '&'));
            }
            Yii::app()->session['returnUrl'] = urldecode(urldecode($returnUrl));
        }
        $this->setState('instagram_redirect_uri', $url);
        return $url;
    }

    protected function getTokenUrl($code)
    {
        return $this->providerOptions['access_token'];
    }

    protected function getAccessToken($code)
    {
        return $this->makeRequest($this->getTokenUrl($code), array('data' => 'client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&grant_type=authorization_code&redirect_uri=' . $this->getState('instagram_redirect_uri') . '&code=' . $code));
    }

    protected function saveAccessToken($token)
    {

        if (isset(Yii::app()->session['instagram_tech']) && (Yii::app()->session['instagram_tech'] == Yii::app()->eauth->services['instagram']['client_id']))
        {
            //технический акк
            $socToken = SocToken::model()->findByAttributes(array(
                'type' => SocToken::TYPE_INSTAGRAM,
                'is_tech' => true
            ));
            if (!$socToken)
                $socToken = new SocToken;
            $socToken->type = SocToken::TYPE_INSTAGRAM;
            $socToken->is_tech = true;
            $socToken->soc_id = $token->user->id;
            $socToken->user_token = $token->access_token;

            $socToken->save();
        }
        else
        {
            $socToken = SocToken::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'type' => SocToken::TYPE_INSTAGRAM,
            ));
            if (!$socToken)
                $socToken = new SocToken;
            $socToken->type = SocToken::TYPE_INSTAGRAM;
            $socToken->user_id = Yii::app()->user->id;
            $socToken->soc_id = $token->user->id;
            $socToken->user_token = $token->access_token;

            $socToken->save();
        }
        //
        $this->setState('auth_token', $token->access_token);
        Yii::app()->session['instagram_token'] = $token->access_token;
        $this->setState('instagram_id', $token->user->id);
        $this->setState('instagram_username', $token->user->username);
        $this->access_token = $token->access_token;
    }

}
