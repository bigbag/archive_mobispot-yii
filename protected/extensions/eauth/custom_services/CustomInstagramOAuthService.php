<?php

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

class CustomInstagramOAuthService extends EOAuth2Service {	
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
	
  protected function fetchAttributes() {
	$this->attributes['id'] = $this->getState('instagram_id');
	$this->attributes['name'] = $this->getState('instagram_username');
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
	if(isset(Yii::app()->session['instagram_tech'])){
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
 
  protected function getCodeUrl($redirect_uri){
    $this->setState('instagram_redirect_uri', urlencode($redirect_uri));
    $url = parent::getCodeUrl($redirect_uri);
	return $url;
  }
  
  protected function getTokenUrl($code)
  {
    return $this->providerOptions['access_token'];
  }

  protected function getAccessToken($code)
  {
    return $this->makeRequest($this->getTokenUrl($code), array('data'=>'client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&grant_type=authorization_code&redirect_uri='.$this->getState('instagram_redirect_uri').'&code=' . $code));
  }

  
  protected function saveAccessToken($token) {
  
    if(isset(Yii::app()->session['instagram_tech']) && (Yii::app()->session['instagram_tech'] == Yii::app()->eauth->services['instagram']['client_id'])){
	//технический акк
      $userSoc=UserSoc::model()->findByAttributes(array(
	    'type'=>10,
		'is_tech'=>true
	  ));	
	  if(!$userSoc)
	    $userSoc = new UserSoc;	
	  $userSoc->type = 10;
	  $userSoc->is_tech = true;		
	  $userSoc->soc_id = $token->user->id;
	  $userSoc->user_token = $token->access_token;

	  $userSoc->save();		
	}/*
    else{
	//обычная авторизация
	  $userSoc=UserSoc::model()->findByAttributes(array(
  	    'user_id'=>Yii::app()->user->id,
	    'type'=>10
	  ));	
	  if(!$userSoc)
	    $userSoc = new UserSoc;

	  $userSoc->user_id = Yii::app()->user->id;
	  $userSoc->soc_id = $token->user->id;
	  $userSoc->user_token = $token->access_token;
	  $userSoc->type = 10;
	  $userSoc->save();	
	}*/
	$this->setState('auth_token', $token->access_token);	
	$this->setState('instagram_id', $token->user->id);
	$this->setState('instagram_username', $token->user->username);
	$this->access_token = $token->access_token;
  }	
}