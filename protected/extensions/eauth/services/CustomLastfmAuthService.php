<?php

require_once dirname(dirname(__FILE__)).'/EAuthServiceBase.php';

class CustomLastfmAuthService extends EAuthServiceBase {	
	
	protected $name = 'Lastfm';
	protected $title = 'Last.fm';
	protected $type = 'OAuth';
	protected $sesionKey = '';
	protected $lfmUsername = '';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));
			
	protected $key = '';
	protected $secret = '';
	protected $providerOptions = array(
		'authorize' => 'http://www.lastfm.ru/api/auth',
	);

	protected function fetchAttributes() {
		if($this->hasState('lfmUsername')){
			$options = array();
			$info = $this->makeRequest('http://ws.audioscrobbler.com/2.0/?method=user.getinfo&user='.$this->getState('lfmUsername').'&api_key='.$this->key.'&format=json', $options, false);
			$info = CJson::decode($info, true);
			$info = $info['user'];
			$this->attributes['id'] = $info['id'];
			
			if(!empty($info['realname']))
				$this->attributes['name'] = $info['realname'];
			else
				$this->attributes['name'] = $info['name'];
			if(!empty($info['image'][1]))
				$this->attributes['photo'] = $info['image'][1]['#text'];
			if(!empty($info['url']))
				$this->attributes['url'] = $info['url'];
			if(!empty($info['country']))
				$this->attributes['location'] = $info['country'];
			if(!empty($info['age']))
				$this->attributes['age'] = $info['age'];
			if(!empty($info['gender']))
				$this->attributes['gender'] = $info['gender'];			

		}
	}

	public function authenticate() {
		if (isset($_GET['token'])) {
			$this->setState('auth_token', $_GET['token']);
			$sign = md5('api_key'.$this->key.'methodauth.getSessiontoken'.$_GET['token'].$this->secret);
			$options = array();
			$sk = $this->makeRequest('http://ws.audioscrobbler.com/2.0/?method=auth.getSession&token='.$_GET['token'].'&api_key='.$this->key.'&api_sig='.$sign, $options, false);
			$xml = new SimpleXMLElement($sk); 
			$attr = $xml->attributes();
			
			if(((string)$attr['status']) == 'ok'){
				$this->setState('lfmUsername', ((string)$xml->session->name));
				$this->setState('sessionKey', ((string)$xml->session->key));
				$this->authenticated = true;
			}
        }
		
		if(!$this->getIsAuthenticated()){
			if (isset($_GET['redirect_uri'])) {
				$redirect_uri = $_GET['redirect_uri'];
			}
			else {
				$server = Yii::app()->request->getHostInfo();
				$path = Yii::app()->request->getUrl();
				$redirect_uri = $server.$path;
			}
			$url = $this->providerOptions['authorize'].'?api_key='.$this->key.'&cb='.urlencode($redirect_uri);
			Yii::app()->request->redirect($url);
		}
		
		return $this->getIsAuthenticated();	
	}
	
}