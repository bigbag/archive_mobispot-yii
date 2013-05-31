<?php

require_once dirname(dirname(__FILE__)).'/EOAuthService.php';

class CustomMySpaceAuthService extends EOAuthService {	
  protected $name = 'myspace';
  protected $title = 'MySpace';
  protected $type = 'OAuth';
  protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
			
  protected $key = '';
  protected $secret = '';
  protected $providerOptions = array(
    'request' => 'http://api.myspace.com/request_token',
    'authorize' => 'http://api.myspace.com/authorize',
    'access' => 'http://api.myspace.com/access_token',
  );

  protected function fetchAttributes() {
    $info = $this->makeSignedRequest('http://api.myspace.com/v1/user.json');
    $this->attributes['id'] = $info->userId;
	if(isset($info->name))
      $this->attributes['name'] = $info->name;
	if(isset($info->image))
      $this->attributes['photo'] = $info->image;
   // $this->attributes['url'] = $info->webUri;
/*		
		$profile = $this->makeSignedRequest('http://api.myspace.com/v1/users/' . $info->userId . '/profile.json');
		if(!empty($profile->age))
		$this->attributes['age'] = $profile->age;
		if(!empty($profile->aboutme))
		$this->attributes['about'] = $profile->aboutme;
		
		if(!empty($profile->country))
			$this->attributes['location'] = $profile->country;
		else
			$this->attributes['location'] = '';
		if(!empty($profile->region)){
			if($this->attributes['location'] == '')
				$this->attributes['location'] = $profile->region;
			else
				$this->attributes['location'] .= ', '.$profile->region;
		}		
		if(!empty($profile->city)){
			if($this->attributes['location'] == '')
				$this->attributes['location'] = $profile->city;
			else
				$this->attributes['location'] .= ', '.$profile->city;
		}
		if($this->attributes['location'] == '')
			unset($this->attributes['location']);		
	
	}
*/
}