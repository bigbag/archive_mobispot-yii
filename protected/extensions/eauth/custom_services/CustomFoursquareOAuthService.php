<?php

require_once dirname(dirname(__FILE__)).'/EOAuth2Service.php';

class CustomFoursquareOAuthService extends EOAuth2Service {	
	
	protected $name = 'foursquare';
	protected $title = 'foursquare';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

	protected $client_id = '';
	protected $client_secret = '';
	protected $providerOptions = array(
		'authorize' => 'https://foursquare.com/oauth2/authenticate', //https://ru.foursquare.com/oauth2/authorize
		'access_token' => 'https://foursquare.com/oauth2/access_token',
	);
	protected function fetchAttributes() {
	//	$info = (array)$this->makeSignedRequest('https://api.foursquare.com/v2/users/self', array(), true);
		$token = $this->getState('auth_token')->access_token;
		$info = (array)$this->makeRequest('https://api.foursquare.com/v2/users/self?oauth_token='.$token, array(), true);
	
		$info = $info['response']->user;

		$this->attributes['id'] = $info->id;
		if(!empty($info->firstName)){
			$this->attributes['first_name'] = $info->firstName;
			if(!empty($info->lastName)){
				$this->attributes['name'] = $info->firstName.' '.$info->lastName;
				$this->attributes['last_name'] = $info->lastName;
			}else{
				$this->attributes['name'] = $info->firstName;
			}
		} else
			$this->attributes['name'] = $info->id;
		$this->attributes['url'] = 'https://ru.foursquare.com/user/'.$info->id;
		if (!empty($info->photo))
			$this->attributes['photo'] = $info->photo;
		if (!empty($info->gender))
			$this->attributes['gender'] = $info->gender;
		if (!empty($info->contact->email))
			$this->attributes['email'] = $info->contact->email;
		if (!empty($info->homeCity))
			$this->attributes['location'] = $info->homeCity;
		if (!empty($info->bio))
			$this->attributes['about'] = $info->bio;
			
		$this->attributes['token'] = $token;
		
		
		$tips = $this->makeCurlRequest('https://api.foursquare.com/v2/lists/'.$info->id.'/tips?client_id=ZIZ1JENX1BIOBZHZKKID0DCDUWGG0ZSBRIEINTGBIMLIOOGP&client_secret=EGTNO2EO0YKT0KLZ5X4DCZMTZLJ4ZHMSIESANZPEBGJZ2CXG&v=20130211');
		if (!empty($tips['response']['list']['listItems']['items']['0']))
			$this->attributes['last_tip'] = '"<a href="'.$tips['response']['list']['listItems']['items']['0']['venue']['canonicalUrl'].'">'.$tips['response']['list']['listItems']['items']['0']['venue']['name'].'</a> :'.$tips['response']['list']['listItems']['items']['0']['tip']['text'].'"';
		$badges = $this->makeCurlRequest('https://api.foursquare.com/v2/users/'.$info->id.'/badges?client_id=ZIZ1JENX1BIOBZHZKKID0DCDUWGG0ZSBRIEINTGBIMLIOOGP&client_secret=EGTNO2EO0YKT0KLZ5X4DCZMTZLJ4ZHMSIESANZPEBGJZ2CXG&v=20130211');
		$last_badge = array();
		if(isset($badges['response']['badges'])){
			foreach($badges['response']['badges'] as $badge){
				if(isset($badge['unlocks'][0]) && !isset($last_badge['id'])){
					$last_badge['id'] = $badge['id'];
					$last_badge['image'] = $badge['image']['prefix'].$badge['image']['sizes']['1'].$badge['image']['name'];
					$last_badge['name'] = $badge['name'];
					$last_badge['date'] = $badge['unlocks'][0]['checkins'][0]['createdAt'];
					$last_badge['timeZoneOffset'] = $badge['unlocks'][0]['checkins'][0]['timeZoneOffset'];
					$last_badge['description'] = $badge['description'];
					$last_badge['badgeText'] = $badge['badgeText'];
					foreach($badge['unlocks'] as $unlock){
						foreach($unlock['checkins'] as $checkin){
							if($checkin['createdAt'] > $last_badge['date'])
								$last_badge['date'] = $checkin['createdAt'];
						}
					}
				}else{
					foreach($badge['unlocks'] as $unlock){
						foreach($unlock['checkins'] as $checkin){
							if($checkin['createdAt'] > $last_badge['date']){
								$last_badge['id'] = $badge['id'];
								$last_badge['image'] = $badge['image']['prefix'].$badge['image']['sizes']['1'].$badge['image']['name'];
								$last_badge['name'] = $badge['name'];
								$last_badge['date'] = $checkin['createdAt'];
								$last_badge['timeZoneOffset'] = $checkin['timeZoneOffset'];
								$last_badge['description'] = $badge['description'];
								$last_badge['badgeText'] = $badge['badgeText'];
							}
						}
					}
					
				}
			}
		}
		
		if(isset($last_badge['id']))
			$this->attributes['last_badge'] = '<div class="badge" style="text-align:center;float:left;"><a href="https://ru.foursquare.com/user/'.$info->id.'/badge/'.$last_badge['id'].'"><img src="'.$last_badge['image'].'" style="width:115px; height:115px;"></a>
            
            <p><a href="https://ru.foursquare.com/user/'.$info->id.'/badge/'.$last_badge['id'].'">'.$last_badge['name'].'</a> </p>
            <p>'.date('F j, Y', ($last_badge['date'] + $last_badge['timeZoneOffset'])).'&nbsp;</p>
			<p>'.$last_badge['description'].'</p>
          </div>';
	}
	
	public function authenticate() {
		// user denied error
		if (isset($_GET['error']) && $_GET['error'] == 'access_denied') {
			$this->cancel();
			return false;
		}

		// Get the access_token and save them to the session.
		if (isset($_GET['code'])) {
            $code = $_GET['code'].'&grant_type=authorization_code&v=20130211';
			$token = $this->getAccessToken($code);
			if (isset($token)) {
				$this->saveAccessToken($token);
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
			Yii::app()->request->redirect($url);
		}

		return $this->getIsAuthenticated();
	}
	
	public function makeCurlRequest($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/../config/ca-bundle.crt');
		 
		 
		$curl_result = curl_exec($ch);
		$headers = curl_getinfo($ch);
		//curl_error($ch);
		curl_close($ch);
		
		if($headers['http_code'] != 200)
			$result = 'error:'.$headers['http_code'];
		else
			$curl_result = CJson::decode($curl_result, true);
		
		return $curl_result;
	}


}