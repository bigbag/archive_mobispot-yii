<?php

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

class CustomBehanceAuthService extends EOAuth2Service {	
	
	protected $name = 'behance';
	protected $title = 'Behance';
	protected $type = 'OAuth';
	protected $scope = 'activity_read|collection_read|wip_read|project_read';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

	protected $client_id = '';
	protected $client_secret = '';
	protected $providerOptions = array(
		'authorize' => 'https://www.behance.net/v2/oauth/authenticate',
		'access_token' => 'https://www.behance.net/v2/oauth/token',
	);
	
	
	protected function fetchAttributes() {
		$options = array();
		$idUser = $this->getState('idUser');
		
		$info = $this->makeRequest('http://www.behance.net/v2/users/'.$idUser.'?api_key='.$this->client_id, $options, false);
		$info = CJson::decode($info, true);
		$info = $info['user'];
		
		$this->attributes['id'] = $info['id'];
		$this->attributes['name'] = $info['username'];
		
		if(!empty($info['first_name']))
			$this->attributes['first_name'] = $info['first_name'];
		if(!empty($info['last_name']))
			$this->attributes['last_name'] = $info['last_name'];

		if(!empty($info['images']['50']))
			$this->attributes['photo'] = $info['images']['50'];
		$this->attributes['soc_url'] = $info['url'];
		if(!empty($info['sections']['Where, When and What']))
			$this->attributes['about'] = $info['sections']['Where, When and What'];
		if(!empty($info['company']))
			$this->attributes['work'] = $info['company'];
		if(!empty($info['country']))
			$this->attributes['location'] = $info['country'];
		else
			$this->attributes['location'] = '';
		if(!empty($info['state'])){
			if($this->attributes['location'] == '')
				$this->attributes['location'] = $info['state'];
			else
				$this->attributes['location'] .= ', '.$info['state'];
		}
		if(!empty($info['city'])){
			if($this->attributes['location'] == '')
				$this->attributes['location'] = $info['city'];
			else
				$this->attributes['location'] .= ', '.$info['city'];
		}
		if($this->attributes['location'] == '')
			unset($this->attributes['location']);
		if(!empty($info['fields'][0])){
			$this->attributes['focus'] = '';
			foreach($info['fields'] as $focus){
				if($this->attributes['focus'] !== '')
					$this->attributes['focus'] .= ', ';
				$this->attributes['focus'] .= $focus;
			}
		}

		$projects = $this->makeRequest('http://www.behance.net/v2/users/'.$idUser.'/projects?api_key='.$this->client_id, $options, false);
		$projects = CJson::decode($projects, true);

		if(!empty($projects['projects'][0])){
			$projects = $projects['projects'][0];
			$imgProject = '';
			if(!empty($projects['covers'][202]))
				$imgProject = '<br/><img src="'.$projects['covers'][202].'"/>';
			$this->attributes['last_status'] = '<a href="'.$projects['url'].'" target="_blank">'.$projects['name'].$imgProject.'</a>';
		}
	}
	
	
	public function authenticate() {
		// user denied error
		if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
			$this->cancel();
			return false;
		}

		// Get the access_token and save them to the session.
		if (isset($_GET['code'])) {
			$code = $_GET['code'];
			$options = array();
			$options['data'] = 'client_id='.$this->client_id.'&client_secret='.$this->client_secret.'&code='.$code.'&redirect_uri='.urlencode($this->getState('redirect_uri')).'&grant_type=authorization_code';
			$token_url = $this->providerOptions['access_token'].'?client_id='.$this->client_id.'&client_secret='.$this->client_secret.'&code='.$code.'&redirect_uri='.urlencode($this->getState('redirect_uri')).'&grant_type=authorization_code';
			//$token = $this->makeRequest($token_url);
			$token = $this->makeRequest($this->providerOptions['access_token'], $options, true);
			if (isset($token)) {
				$this->saveAccessToken($token->access_token);
				$this->setState('idUser', $token->user->id);
				$this->authenticated = true;
			}
        }
		// Redirect to the authorization page
		else if (!$this->restoreAccessToken()) {
			// Use the URL of the current page as the callback URL.
			if (isset($_GET['redirect_uri'])) {
				$redirect_uri = $_GET['redirect_uri'];
			}
			else {
				$server = Yii::app()->request->getHostInfo();
				$path = Yii::app()->request->getUrl();
				$redirect_uri = $server.$path;
			}
			$url = $this->getCodeUrl($redirect_uri);
			$url = $url.'&state=state';
			Yii::app()->request->redirect($url);
		}

		return $this->getIsAuthenticated();
	}

}