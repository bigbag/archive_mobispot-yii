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
    $info = (array)$this->makeSignedRequest('https://www.googleapis.com/oauth2/v1/userinfo');

    $this->attributes['id'] = $info['id'];
    $this->attributes['name'] = $info['name'];
    if (!empty($info['link']))
      $this->attributes['url'] = $info['link'];
    if (!empty($info['picture']))
      $this->attributes['photo'] = $info['picture'];
    if (!empty($info['email']))
      $this->attributes['email'] = $info['email'];
      
    if (!Yii::app()->user->isGuest)
    {
        $socToken=SocToken::model()->findByAttributes(array(
                    'user_id'=>Yii::app()->user->id,
                    'type'=>SocToken::TYPE_GOOGLE,
                ));
        
        if($socToken)
        {
            $socToken->soc_id = $info['id'];
            $socToken->soc_username = $info['name'];
            $socToken->soc_email = $info['email'];
            $socToken->save();
        }
    }
/*      
    if (!empty($info['link']))
      $this->attributes['url'] = $info['link'];
    if (!empty($info['gender']))
      $this->attributes['gender'] = $info['gender'];
    if (!empty($info['language']))  
      $this->attributes['language'] = $info['locale'];
*/
/*      
    $sinfo = new SocInfo;
    $FreeUserDetail = array();    
    $FreeUserDetail = $sinfo->GetSocInfo('Google', $info['id']);
    if(isset($FreeUserDetail['UserExists']) && ($FreeUserDetail['UserExists'] === true)){
        if(isset($FreeUserDetail['work']))
            $this->attributes['work'] = $FreeUserDetail['work'];
        if(isset($FreeUserDetail['school']))
            $this->attributes['school'] = $FreeUserDetail['school'];
        if(isset($FreeUserDetail['first_name']))
            $this->attributes['first_name'] = $FreeUserDetail['first_name'];
        if(isset($FreeUserDetail['last_name']))
            $this->attributes['last_name'] = $FreeUserDetail['last_name'];
        if(isset($FreeUserDetail['aboutMe']))
            $this->attributes['about'] = $FreeUserDetail['aboutMe'];
        if(isset($FreeUserDetail['location']))
            $this->attributes['location'] = $FreeUserDetail['location'];
            
            
    }
*/        

  }
  
    protected function getCodeUrl($redirect_uri)
    {
        $this->setState('redirect_uri', $redirect_uri);
        $url = parent::getCodeUrl($redirect_uri);
        if (isset($_GET['js']) and !strpos($url, 'display=popup'))
            $url .= '&display=popup';
            
        $url .= '&access_type=offline';
        
        $socToken=SocToken::model()->findByAttributes(array(
                    'user_id'=>Yii::app()->user->id,
                    'type'=>SocToken::TYPE_GOOGLE,
                ));
        
        if(!$socToken or !$socToken->refresh_token)
        {
            $url .= '&approval_prompt=force';
        }
        
        return $url;
    }
 
    protected function saveAccessToken($token)
    {
        if (!Yii::app()->user->isGuest){
            $socToken=SocToken::model()->findByAttributes(array(
                'user_id'=>Yii::app()->user->id,
                'type'=>SocToken::TYPE_GOOGLE,
            ));
            if(!$socToken)
                $socToken = new SocToken;
            $socToken->type = SocToken::TYPE_GOOGLE;
            $socToken->user_id = Yii::app()->user->id;
            $socToken->user_token = $token->access_token;
            if (!empty($token->refresh_token))
                $socToken->refresh_token = $token->refresh_token;
            $socToken->token_expires = time() + $token->expires_in - 60;
            
            $socToken->save();
            
            parent::saveAccessToken($token);
            $this->setState('auth_token', $token->access_token);
            $this->setState('expires', time() + $token->expires_in - 60);
            $this->access_token = $token->access_token;
        }
    }
}