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
	if (!empty($info->contact->email))
	  $this->attributes['email'] = $info->contact->email;	  
	  
	$user=User::model()->findByPk(Yii::app()->user->id);
	$user->foursquare_id = $info->id;
	$user->save();	  
/*
	if (!empty($info->gender))
	  $this->attributes['gender'] = $info->gender;
	if (!empty($info->homeCity))
	  $this->attributes['location'] = $info->homeCity;
	if (!empty($info->bio))
	  $this->attributes['about'] = $info->bio;
*/
  //$this->attributes['token'] = $token;
/*		
		

		$tips = $this->makeCurlRequest('https://api.foursquare.com/v2/lists/'.$info->id.'/tips?client_id=ZIZ1JENX1BIOBZHZKKID0DCDUWGG0ZSBRIEINTGBIMLIOOGP&client_secret=EGTNO2EO0YKT0KLZ5X4DCZMTZLJ4ZHMSIESANZPEBGJZ2CXG&v=20130211');
		if (!empty($tips['response']['list']['listItems']['items']['0']))
			$this->attributes['last_tip'] = '"<a href="'.$tips['response']['list']['listItems']['items']['0']['venue']['canonicalUrl'].'">'.$tips['response']['list']['listItems']['items']['0']['venue']['name'].'</a> :'.$tips['response']['list']['listItems']['items']['0']['tip']['text'].'"';
		$badges = $this->makeCurlRequest('https://api.foursquare.com/v2/users/'.$info->id.'/badges?client_id='.Yii::app()->eauth->services['foursquare']['client_id'].'&client_secret='.Yii::app()->eauth->services['foursquare']['client_secret'].'&v=20130211');
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
*/		  
  }

  protected function getAccessToken($code)
  {
	$token_answer = $this->makeRequest($this->getTokenUrl($code));
	$user=User::model()->findByPk(Yii::app()->user->id);
	$user->foursquare_token = $token_answer->access_token;
	$user->save();
    return $token_answer;
  }
  
  
  protected function getCodeUrl($redirect_uri){
    $this->setState('foursquare_redirect_uri', urlencode($redirect_uri));
    $url = parent::getCodeUrl($redirect_uri).'&v=20130607';
	return $url;
  }
  
  protected function getTokenUrl($code)
  {
    return $this->providerOptions['access_token'] . '?client_id=' . $this->client_id . '&client_secret=' . $this->client_secret . '&grant_type=authorization_code&redirect_uri='.$this->getState('foursquare_redirect_uri').'&code='.$code.'&v=20130607';
  }
}