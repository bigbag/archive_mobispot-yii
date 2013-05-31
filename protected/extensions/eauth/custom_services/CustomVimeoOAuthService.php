<?php

require_once dirname(dirname(__FILE__)).'/EOAuthService.php';

class CustomVimeoOAuthService extends EOAuthService {	
	
  protected $vimeo;
  protected $name = 'vimeo';
  protected $title = 'vimeo';
  protected $type = 'OAuth';
  protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
			
  protected $key = '';
  protected $secret = '';
  protected $providerOptions = array(
    'request' => 'https://vimeo.com/oauth/request_token',
    'authorize' => 'https://vimeo.com/oauth/authorize',
    'access' => 'https://vimeo.com/oauth/access_token',
  );
/*	
	public function __construct() {
		Yii::import('ext.vimeo.phpVimeo');
		$this->vimeo = new phpVimeo('42a46871a80d8c21736b27a73960a58cc2c9d658', 'c47be64db67d76e07ae90b0581149ae846dcc889');

	}
*/	
  protected function fetchAttributes() {
    Yii::import('ext.vimeo.phpVimeo');
    $token = $this->getAccessToken();
		//oauth_token=17190f3e0c93c7a7a2f7c23f1ee4e686&oauth_token_secret=0a0a6f4646e22c3ebb347f0a51aa9d20bf9b8786
		//$info = $this->makeSignedRequest('http://vimeo.com/api/rest/v2?method=vimeo.people.getInfo?user_id=16398847', array(), false);
		
    $oauth_token = substr($token, (strpos($token, 'oauth_token=')+12), (strpos($token, '&oauth_token_secret=')-12));
    $token_secret = substr($token, (strpos($token, '&oauth_token_secret=')+20));
		
    $this->vimeo = new phpVimeo(Yii::app()->eauth->services['vimeo']['key'], Yii::app()->eauth->services['vimeo']['secret'], $oauth_token, $token_secret);
    $info = $this->vimeo->call('vimeo.people.getInfo', array('user_id' => $oauth_token));
    $info = $info->person;
		
    $this->attributes['id'] = $info->id;
	if(isset($info->display_name))
      $this->attributes['name'] = $info->display_name;
	if(isset($info->profileurl))
      $this->attributes['url'] = $info->profileurl;
    if(isset($info->portraits)){
      $portrait = $info->portraits->portrait;
      foreach($portrait as $p){
        if(($p->width == 30) && !empty($p->_content))
          $this->attributes['photo'] = $p->_content;
      }
    }
	
    if(isset($info->bio) && !empty($info->bio))
      $this->attributes['about'] = $info->bio;
    if(isset($info->location) && !empty($info->location))
      $this->attributes['location'] = $info->location;
			
	/*		
    $video = $this->vimeo->call('vimeo.videos.getAll', array('user_id' => $oauth_token, 'sort'=>'newest', 'page'=>1, 'per_page'=>1, 'full_response'=>true));
		
    //$video = $video->videos->video[0]->urls->url[0]->_content;
	if(isset($video->videos) && isset($video->videos->video) && isset($video->videos->video[0]) && isset($video->videos->video[0]->id)){
      $video = $video->videos->video[0]->id;
      $this->attributes['last_video'] =$video;
	}
	*/
  }
}