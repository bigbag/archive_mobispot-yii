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
    $info = $this->makeSignedRequest('https://api.instagram.com/v1/users/self');
	$this->attributes['id'] = $this->getState('idUser');
	$this->attributes['name'] = $this->getState('username');
	$info = $info->data;
	if(!empty($info->username))
	  $this->attributes['url'] = 'http://instagram.com/'.$info->username;
	/*  
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
	
    $media = $this->makeSignedRequest('https://api.instagram.com/v1/users/'.$this->getState('idUser').'/media/recent');
    if(!empty($media->data[0])){
      $media = $media->data[0];
	  $this->attributes['last_status'] = '<a href="'.$media->link.'" target="_blank">'.$media->caption->text.'<br/><img src="'.$media->images->standard_resolution->url.'"/></a>';
    }
	*/
  }
/*
  protected function getAccessToken($code) {
	$params = array(
		'client_id' => $this->client_id,
		'client_secret' => $this->client_secret,
		'grant_type' => 'authorization_code',
		'code' => $code,
		'redirect_uri' => $this->getState('redirect_uri'),
	);
	return $this->makeRequest($this->getTokenUrl($code), array('data' => $params));
  }	
 */ 
 
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
	$this->setState('auth_token', $token->access_token);
	$this->setState('idUser', $token->user->id);
	$this->setState('username', $token->user->username);
	$this->access_token = $token->access_token;
  }	
}