<?php

class SocInfo extends CFormModel
{
  public $socNet = '';
  public $socUsername = '';
  public $accessToken = '';
  public $userDetail = array();
  public $socNetworks = array();

  public function __construct(){
    $this->socNetworks = SocInfo::getSocNetworks();
  }

  public static function getSocNetworks(){
    $socNetworks = array();
    $net = array();

    $net['name'] = 'facebook';
    $net['baseUrl'] = 'facebook.com';
    $net['invite'] = Yii::t('eauth', 'Read more on');
    $net['inviteClass'] = 'i-soc-fac';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = 'i-fb.2x.png';
    $socNetworks[] = $net;

    $net['name'] = 'twitter';
    $net['baseUrl'] = 'twitter.com';
    $net['invite'] = Yii::t('eauth', 'Follow me on');
    $net['inviteClass'] = 'i-soc-twi';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = 'i-twitter.2x.png';
    $socNetworks[] = $net;

    $net['name'] = 'google_oauth';
    $net['baseUrl'] = 'google.com';
    $net['invite'] = Yii::t('eauth', 'Read more on Google');
    $net['inviteClass'] = 'hide';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = 'google16.png';
    $socNetworks[] = $net;

    $net['name'] = 'ВКонтакте';
    $net['baseUrl'] = 'vk.com';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;
/*
    $net['name'] = 'Linkedin';
    $net['baseUrl'] = 'linkedin.com';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;
*/
    $net['name'] = 'Foursquare';
    $net['baseUrl'] = 'foursquare.com';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;

    $net['name'] = 'vimeo';
    $net['baseUrl'] = 'vimeo.com';
    $net['invite'] = Yii::t('eauth', 'Watch more');
    $net['inviteClass'] = 'i-soc-vimeo';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = 'i-vimeo.2x.png';
    $socNetworks[] = $net;

    $net['name'] = 'Last.fm';
    $net['baseUrl'] = 'lastfm.ru';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;

    $net['name'] = 'deviantart';
    $net['baseUrl'] = 'deviantart.com';
    $net['invite'] = Yii::t('eauth', 'Watch more');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;

    $net['name'] = 'Behance';
    $net['baseUrl'] = 'behance.net';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;

    $net['name'] = 'Flickr';
    $net['baseUrl'] = 'flickr.com';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;

    $net['name'] = 'YouTube';
    $net['baseUrl'] = 'youtube.com';
    $net['invite'] = Yii::t('eauth', 'Watch more');
    $net['inviteClass'] = '';
    $net['note'] = Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;
/*
    $net['name'] = 'Instagram';
    $net['baseUrl'] = 'instagram.com';
    $net['invite'] = Yii::t('eauth', '');
    $net['inviteClass'] = '';
    $net['note'] =  Yii::t('eauth', '');
    $net['smallIcon'] = '';
    $socNetworks[] = $net;
*/
    return $socNetworks;
  }

  public function getNetData($link){
    $this->socNet = '';
    $this->socUsername = '';
    $this->userDetail = array();
    $isSocNet = $this->detectNetByLink($link);

    if($isSocNet != 'no'){
      $net = $this->getNetByName($isSocNet);
      $this->socNet = $net['name'];
      $this->socUsername = $this->parceSocUrl($this->socNet, $link);
      $this->getSocInfo($this->socNet, $this->socUsername);
      $this->userDetail['invite'] = $net['invite'];
      $this->userDetail['inviteClass'] = $net['inviteClass'];
      $this->userDetail['netName'] = $this->socNet;
    }
    return $this->userDetail;
  }

  public function detectNetByLink($link){
    $answer = 'no';
    foreach($this->socNetworks as $net){
      if (strpos($link, $net['baseUrl']) !== false){
        $answer = $net['name'];
        break;
      }
    }
    return $answer;
  }

  public function getNetByName($name){
    $answer = array();
    foreach($this->socNetworks as $net){
      if ($name == $net['name']){
        $answer = $net;
        break;
      }
    }
    return $answer;
  }

  public function getSocInfo($socNet, $socUsername){
    $this->socNet = $socNet;
    $this->socUsername = $socUsername;

    $this->userDetail['service']= $socNet;
    $this->userDetail['UserExists'] = false;
    $socUsername = $this->parceSocUrl($socNet, $socUsername);

    if($socNet == 'google_oauth'){
      $url = 'https://www.googleapis.com/plus/v1/people/'.$socUsername.'?key='.Yii::app()->eauth->services['google_oauth']['key'];
//$url = 'https://www.googleapis.com/plus/v1/people/+GuyKawasaki?key=AIzaSyA4g3rLLua1lK3YKss_ANG7t1klz_aGvak';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/../config/ca-bundle.crt');

      $curl_result = curl_exec($ch);
      curl_close($ch);

      $socUser = CJSON::decode($curl_result, true);
//$this->userDetail['last_status'] = 'last_status';
      if(!isset($socUser['error'])){
        $this->userDetail['UserExists'] = true;
        if(isset($socUser['displayName']))
            $this->userDetail['soc_username'] = $socUser['displayName'];
        if(isset($socUser['image']['url']))
            $this->userDetail['photo'] = $socUser['image']['url'];
        if(isset($socUser['name']['givenName']))
            $this->userDetail['first_name'] = $socUser['name']['givenName'];
        if(isset($socUser['name']['familyName']))
            $this->userDetail['last_name'] = $socUser['name']['familyName'];
        if(isset($socUser['gender']))
            $this->userDetail['gender'] = $socUser['gender'];
        if(isset($socUser['placesLived'])){
          foreach($socUser['placesLived'] as $place){
            if(isset($place['primary']) && ($place['primary']==true))
              $this->userDetail['location'] = $place['value'];
          }
        }
        if(isset($socUser['organizations'])){
          foreach($socUser['organizations'] as $org){
            if(isset($org['primary']) && ($org['primary']==true)){
              if($org['type'] == 'work')
                $this->userDetail['work'] = $org['name'];
              else if($org['type'] == 'school')
                $this->userDetail['school'] = $org['name'];
            }
          }

        }
        if(isset($socUser['aboutMe']))
            $this->userDetail['about'] = $socUser['aboutMe'];
        if(isset($socUser['url']))
            $this->userDetail['soc_url'] = $socUser['url'];
      }else{
        $this->userDetail['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
      }
    }elseif($socNet == 'facebook'){
        $socUser = $this->makeRequest('https://graph.facebook.com/'.$socUsername);

        if (!isset($socUser['error'])){
          $this->userDetail['UserExists'] = true;
          //$this->userDetail['soc_id'] = $socUser['id'];
          $this->userDetail['photo'] = 'http://graph.facebook.com/'.$socUsername.'/picture';
          if(isset($socUser['name']))
            $this->userDetail['soc_username'] = $socUser['name'];
          if(isset($socUser['first_name']))
            $this->userDetail['first_name'] = $socUser['first_name'];
          if(isset($socUser['last_name']))
            $this->userDetail['last_name'] = $socUser['last_name'];
          if(isset($socUser['soc_url']))
            $this->userDetail['soc_url'] = $socUser['link'];
          if(isset($socUser['gender']))
            $this->userDetail['gender'] = $socUser['gender'];
          if(isset($socUser['locale']))
            $this->userDetail['locale'] = $socUser['locale'];
          //последний пост
          $appToken = Yii::app()->cache->get('facebookAppToken');
          $isAppTokenValid = false;

          if($appToken !== false){
            $validation = $this->makeRequest('https://graph.facebook.com/debug_token?input_token='.$appToken.'&access_token='.$appToken, array(), false);
            $validation = CJSON::decode($validation, true);
            if(isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true'))
              $isAppTokenValid = true;
          }

          if(!$isAppTokenValid){
		    if (@fopen('https://graph.facebook.com/oauth/access_token?client_id='.Yii::app()->eauth->services['facebook']['client_id'].'&client_secret='.Yii::app()->eauth->services['facebook']['client_secret'].'&grant_type=client_credentials', 'r')){
              $textToken = fopen('https://graph.facebook.com/oauth/access_token?client_id='.Yii::app()->eauth->services['facebook']['client_id'].'&client_secret='.Yii::app()->eauth->services['facebook']['client_secret'].'&grant_type=client_credentials', 'r');
              $appToken = fgets($textToken);
              fclose($textToken);
              if((strpos($appToken, 'access_token=') > 0) || (strpos($appToken, 'access_token=') !== false))
                $appToken = substr($appToken, (strpos($appToken, 'access_token=')+13));
              Yii::app()->cache->set('facebookAppToken', $appToken);
	  		  $isAppTokenValid = true;
			}
          }

          $userFeed = $this->makeRequest('https://graph.facebook.com/'.$socUsername.'/feed?access_token='.$appToken);
          unset($lastPost);
          $i=0;
          $prevPageUrl= '';

          if(isset($userFeed['data']) && isset($userFeed['data'][$i]) && isset($userFeed['data'][$i]['from']) && isset($userFeed['data'][$i]['from']['id'])){
            while(!isset($lastPost)){
              if(($userFeed['data'][$i]['from']['id'] == $socUser['id']) && !isset($userFeed['data'][$i]['application'])){
                $lastPost = $userFeed['data'][$i];
              }

              //следующая страница
              if($i >= count($userFeed['data'])){
                if(isset($userFeed['paging']['previous']) && ($userFeed['paging']['previous'] != $prevPageUrl)){
                  $prevPageUrl = $userFeed['paging']['previous'];
                  $userFeed = $this->makeRequest($userFeed['paging']['previous'].'&access_token='.$appToken);
                  $i=0;
                }else{
                  $lastPost = 'no';
                }
              } else{
                $i++;
              }
            }

            if($lastPost != 'no'){
              if($lastPost['type'] == 'photo'){
                $this->userDetail['last_img'] =  $lastPost['picture'];
                if(isset($lastPost['message']))
                  $this->userDetail['last_img_msg'] =  $lastPost['message'];
                if(isset($lastPost['story']))
                  $this->userDetail['last_img_story'] =  $lastPost['story'];
              }elseif(($lastPost['type'] == 'status') && isset($lastPost['place']) && isset($lastPost['place']['location']) && isset($lastPost['place']['location']['latitude'])){
                //"место" на карте
                if(isset($lastPost['message']))
                  $this->userDetail['place_msg'] = $lastPost['message'];
                $this->userDetail['place_lat'] = $lastPost['place']['location']['latitude'];
                $this->userDetail['place_lng'] = $lastPost['place']['location']['longitude'];
                $this->userDetail['place_name'] = $lastPost['place']['name'];
              }else{
                if(isset($lastPost['message']))
                  $this->userDetail['last_status'] = $lastPost['message'];
                elseif(isset($lastPost['story']))
                  $this->userDetail['last_status'] = $lastPost['story'];
              }
            }
          }
        }else{
          $this->userDetail['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
        }

      }elseif($socNet == 'twitter'){
        if (@fopen('http://api.twitter.com/1/users/show.json?screen_name='.$socUsername, 'r')){
          $t_json = fopen('http://api.twitter.com/1/users/show.json?screen_name='.$socUsername, 'r');
          $curl_result = fgets($t_json);
          fclose($t_json);

          $socUser = CJSON::decode($curl_result, true);
          $this->userDetail['UserExists'] = true;
          if(isset($socUser['profile_image_url']))
            $this->userDetail['photo'] = $socUser['profile_image_url'];
          if(isset($socUser['name']))
            $this->userDetail['soc_username'] = $socUser['name'];
          if(isset($socUser['location']))
            $this->userDetail['location'] = $socUser['location'];
          if(isset($socUser['screen_name']))
            $this->userDetail['soc_url'] = 'https://twitter.com/'.$socUser['screen_name'];
          if(isset($socUser['url']))
            $this->userDetail['user_site'] = $socUser['url'];
          if(isset($socUser['locale']))
            $this->userDetail['locale'] = $socUser['locale'];
          if(isset($socUser['description']))
            $this->userDetail['about'] = $socUser['description'];
          if(isset($socUser['status']['text']))
            $this->userDetail['last_status'] = $socUser['status']['text'];

        }else{
          $this->userDetail['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
        }
      }elseif($socNet == 'ВКонтакте'){
        $url = 'https://api.vk.com/method/users.get.json?uids='.$socUsername.'&fields=uid,first_name,last_name,nickname,screen_name,sex,bdate(birthdate),city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,contacts,education,online,counters';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/../config/ca-bundle.crt');

        $curl_result = curl_exec($ch);
        //curl_error($ch);
        curl_close($ch);

        $socUser = CJSON::decode($curl_result, true);
        $socUser = $socUser['response'][0];
        if(!isset($socUser['error'])){
          $this->userDetail['soc_username']= $socUser['first_name'].' '.$socUser['last_name'];
          if(!empty($socUser['photo']))
            $this->userDetail['photo'] = $socUser['photo'];
          $this->userDetail['soc_url'] = 'http://vk.com/id'.$socUsername;
          if(!empty($socUser['sex']))
            $this->userDetail['gender'] = $socUser['sex'] == 1 ? 'Ж' : 'М';
          if (!empty($socUser['university_name']))
            $this->userDetail['school'] = $socUser['university_name'];
          if (!empty($socUser['timezone']))
            $this->userDetail['timezone'] = timezone_name_from_abbr('', $socUser['timezone']*3600, date('I'));
          /*if (!empty($socUser['country'])){
            //$countries = (array)$this->makeSignedRequest('https://api.vk.com/method/places.getCountries.json');
            /*$token

            $countries = $this->makeCurlRequest('https://api.vk.com/method/places.getCountries.json');
            $this->userDetail['location'] = print_r($countries, true);
            /*
            foreach($countries['response'] as $country){
              if($country->cid == $socUser['country'])
                $socUser['location'] = $country->title;
            }


          }
          */
        }else{
          $this->userDetail['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
        }
      }elseif($socNet == 'Linkedin'){
        Yii::import('ext.eoauth.*');

        $consumer = new OAuthConsumer('pgweaq9fm86c', 'hlGC8Jy64THUXdqA');
        $scope = 'r_basicprofile';
/*
        $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
                  ? 'https://' : 'http://';
        $callbackUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];

        $token = EOAuthUtils::GetRequestToken($consumer, $scope, 'https://api.linkedin.com/uas/oauth/requestToken', 'My Web Application', $callbackUrl);
*/
        $token = Yii::app()->user->token;

        $methodApi = 'id=';
        if (strpos($socUsername, 'http://www.linkedin.com/pub/') === true){
          $methodApi= 'url=';
          $socUsername = $this->js_urlencode($socUsername);
        }

        $url = 'http://api.linkedin.com/v1/people/'.$methodApi.$socUsername.':(id,first-name,last-name,public-profile-url,headline,picture-url,location,current-status)';

        $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();

        $options = array();
        $query = null;

        $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $url, $query);
        $request->sign_request($signatureMethod, $consumer, $token);
        $answer = $this->makeRequest($request->to_url(), $options, false);

        if($answer != 'error:404'){

          $socUser = $this->xmlToArray(simplexml_load_string($answer));

          $this->userDetail['soc_username'] = $socUser['first-name'].' '.$socUser['last-name'];

          if (!empty($socUser['headline']))
            $this->userDetail['about'] = $socUser['headline'];
          if (!empty($socUser['picture-url']))
            $this->userDetail['photo'] = $socUser['picture-url'];
          if (!empty($socUser['location']['name']))
            $this->userDetail['location'] = $socUser['location']['name'];
          if (!empty($socUser['current-status']))
            $this->userDetail['last_status'] = $socUser['current-status'];
        }else{
          $this->userDetail['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
        }
      }elseif($socNet == 'Foursquare'){
        if(!is_numeric($socUsername)){
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'https://ru.foursquare.com/'.$socUsername);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/../config/ca-bundle.crt');
          $profile = curl_exec($ch);
          //$headers = curl_getinfo($ch);
          curl_close($ch);
          $match = array();
          preg_match('~user: {"id":"[0-9]+","firstName":~', $profile, $match);
          if(isset($match[0]) && (strpos($match[0], 'user: {"id":"') !== false)){
            $socUsername = str_replace('user: {"id":"', '', $match[0]);
            $socUsername = str_replace('","firstName":', '', $socUsername);
          }
        }
        /* search user by twitter nikname - user's authorization needed*/
        /*
          $token = Yii::app()->user->token;
          $user = (array)$this->makeRequest('https://api.foursquare.com/v2/users/search?twitter='.$socUsername.'&oauth_token='.$token.'&v=20130211', array(), true);
          $socUser = $user['response']['results']['0'];
          $socUsername = $socUser['id'];
        */

          $socUser = $this->makeCurlRequest('https://api.foursquare.com/v2/users/'.$socUsername.'?client_id=ZIZ1JENX1BIOBZHZKKID0DCDUWGG0ZSBRIEINTGBIMLIOOGP&client_secret=EGTNO2EO0YKT0KLZ5X4DCZMTZLJ4ZHMSIESANZPEBGJZ2CXG&v=20130211');
          $socUser = $socUser['response']['user'];

          if(!empty($socUser['firstName'])){
            if(!empty($socUser['lastName']))
              $this->userDetail['soc_username'] = $socUser['firstName'].' '.$socUser['lastName'];
            else
              $this->userDetail['soc_username'] = $socUser['firstName'];
          }else
            $this->userDetail['soc_username'] = $socUser['id'];
          $this->userDetail['url'] = 'https://ru.foursquare.com/user/'.$socUser['id'];
          if (!empty($socUser['photo']['prefix']))
            $this->userDetail['photo'] = $socUser['photo']['prefix'].'100x100'.$socUser['photo']['suffix'];
          if (!empty($socUser['gender']))
            $this->userDetail['gender'] = $socUser['gender'];
          if (!empty($socUser['homeCity']))
            $this->userDetail['location'] = $socUser['homeCity'];
          if (!empty($socUser['bio']))
            $this->userDetail['about'] = $socUser['bio'];
          $tips = $this->makeCurlRequest('https://api.foursquare.com/v2/lists/'.$socUsername.'/tips?client_id=ZIZ1JENX1BIOBZHZKKID0DCDUWGG0ZSBRIEINTGBIMLIOOGP&client_secret=EGTNO2EO0YKT0KLZ5X4DCZMTZLJ4ZHMSIESANZPEBGJZ2CXG&v=20130211');
          if (!empty($tips['response']['list']['listItems']['items']['0']))
            $this->userDetail['last_tip'] = '"<a href="'.$tips['response']['list']['listItems']['items']['0']['venue']['canonicalUrl'].'">'.$tips['response']['list']['listItems']['items']['0']['venue']['name'].'</a> :'.$tips['response']['list']['listItems']['items']['0']['tip']['text'].'"';
          $badges = $this->makeCurlRequest('https://api.foursquare.com/v2/users/'.$socUsername.'/badges?client_id=ZIZ1JENX1BIOBZHZKKID0DCDUWGG0ZSBRIEINTGBIMLIOOGP&client_secret=EGTNO2EO0YKT0KLZ5X4DCZMTZLJ4ZHMSIESANZPEBGJZ2CXG&v=20130211');
          $last_badge = array();
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

          if(isset($last_badge['id']))
            $this->userDetail['last_badge'] = '<div class="badge" style="text-align:center;float:left;"><a href="https://ru.foursquare.com/user/'.$socUsername.'/badge/'.$last_badge['id'].'"><img src="'.$last_badge['image'].'" style="width:115px; height:115px;"></a>

            <p><a href="https://ru.foursquare.com/user/'.$socUsername.'/badge/'.$last_badge['id'].'">'.$last_badge['name'].'</a> </p>
            <p>'.date('F j, Y', ($last_badge['date'] + $last_badge['timeZoneOffset'])).'&nbsp;</p>
      <p>'.$last_badge['description'].'</p>
          </div>';


      }elseif($socNet == 'vimeo'){
        $socUser = $this->makeCurlRequest('http://vimeo.com/api/v2/'.$socUsername.'/info.json');
        if(!is_string($socUser)){
          $this->userDetail['soc_username'] = $socUser['display_name'];
          $this->userDetail['soc_url'] = $socUser['profile_url'];
          if (isset($socUser['portrait_small']) and !empty($socUser['portrait_small']))
            $this->userDetail['photo'] = $socUser['portrait_small'];
          if (isset($socUser['location']) and !empty($socUser['location']))
            $this->userDetail['location'] = $socUser['location'];
          if (isset($socUser['bio']) and !empty($socUser['bio']))
            $this->userDetail['about'] = $socUser['bio'];

          $video = $this->makeCurlRequest('http://vimeo.com/api/v2/'.$socUsername.'/videos.json');
          if(isset($video[0]['id']))
            $this->userDetail['vimeo_last_video'] = $video[0]['id'];
        }else
          $this->userDetail['soc_username'] = Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
      // Last.fm
      }elseif($socNet == 'Last.fm'){
        $socUser = $this->makeCurlRequest('http://ws.audioscrobbler.com/2.0/?method=user.getinfo&user='.$socUsername.'&api_key=6a76cdf194415b30b2f94a1aadb38b3e&format=json');
        $socUser = $socUser['user'];
        if(!empty($socUser['realname']))
          $this->userDetail['soc_username'] = $socUser['realname'];
        else
          $this->userDetail['soc_username'] = $socUser['name'];
        if(!empty($socUser['image'][1]))
          $this->userDetail['photo'] = $socUser['image'][1]['#text'];
        if(!empty($socUser['url']))
          $this->userDetail['soc_url'] = $socUser['url'];
        if(!empty($socUser['country']))
          $this->userDetail['location'] = $socUser['country'];
        if(!empty($socUser['age']))
          $this->userDetail['age'] = $socUser['age'];
        if(!empty($socUser['gender']))
          $this->userDetail['gender'] = $socUser['gender'];
      }elseif($socNet == 'deviantart'){
        $options=array();
        $ch = $this->initRequest('http://'.$socUsername.'.deviantart.com', $options);
        $result = curl_exec($ch);
        $headers = curl_getinfo($ch);
        if($headers['http_code'] == 200){

          $this->userDetail['soc_username'] = $socUsername;
          $this->userDetail['soc_url'] = 'http://'.$socUsername.'.deviantart.com';

          $userLent = $this->makeRequest('http://backend.deviantart.com/rss.xml?q=by%3A'.$socUsername.'+sort%3Atime+meta%3Aall', $options, false);
          $xml = new SimpleXMLElement($userLent);
          if(isset($xml->channel->item[0]->link))
            $this->userDetail['last_status'] = '';
          $i=0;//оставлено под счетчик, если требуется вытащить более одной записи

          if(isset($xml->channel->item[$i]->link)){
            $dev_link = (string)$xml->channel->item[$i]->link;
            $last_dev = $this->makeRequest('http://backend.deviantart.com/oembed?url='.$dev_link);

            if(!empty($last_dev['title'])){
				$this->userDetail['last_status'] = $last_dev['title'];
              //if($i > 0)
              //  $this->userDetail['last_status'] .= '<hr/>';
              if(!empty($last_dev['thumbnail_url'])){
                $this->userDetail['last_img'] = $last_dev['thumbnail_url'];
				//$this->userDetail['last_img_msg'] = $last_dev['title'];
              }
            }
          }
        }else
          $this->userDetail['soc_username'] =  Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
      }elseif($socNet == 'Behance'){
        $socUser = $this->makeRequest('http://www.behance.net/v2/users/'.$socUsername.'?api_key=PRn69HKifRiUjKnfOpPGcL24v7y8z21f');
        $socUser = $socUser['user'];
        if(!empty($socUser['display_name']))
          $this->userDetail['soc_username'] = $socUser['display_name'];
        else
          $this->userDetail['soc_username'] = $socUser['username'];
        if(!empty($socUser['images']['50']))
          $this->userDetail['photo'] = $socUser['images']['50'];
        $this->userDetail['soc_url'] = $socUser['url'];
        if(!empty($socUser['sections']['Where, When and What']))
          $this->userDetail['about'] = $socUser['sections']['Where, When and What'];
        if(!empty($socUser['company']))
          $this->userDetail['work'] = $socUser['company'];
        if(!empty($socUser['country']))
          $this->userDetail['location'] = $socUser['country'];
        else
          $this->userDetail['location'] = '';
        if(!empty($socUser['state'])){
          if($this->userDetail['location'] == '')
            $this->userDetail['location'] = $socUser['state'];
          else
            $this->userDetail['location'] .= ', '.$socUser['state'];
        }
        if(!empty($socUser['city'])){
          if($this->userDetail['location'] == '')
            $this->userDetail['location'] = $socUser['city'];
          else
            $this->userDetail['location'] .= ', '.$socUser['city'];
        }
        if($this->userDetail['location'] == '')
          unset($this->userDetail['location']);
        if(!empty($socUser['fields'][0])){
          $this->userDetail['focus'] = '';
          foreach($socUser['fields'] as $focus){
            if($this->userDetail['focus'] !== '')
              $this->userDetail['focus'] .= ', ';
            $this->userDetail['focus'] .= $focus;
          }
        }

        $projects = $this->makeRequest('http://www.behance.net/v2/users/'.$socUsername.'/projects?api_key=PRn69HKifRiUjKnfOpPGcL24v7y8z21f');
        if(isset($projects['projects'][0])){
          $projects = $projects['projects'][0];
          $imgProject = '';
          if(isset($projects['covers'][202]))
            $imgProject = '<br/><img src="'.$projects['covers'][202].'"/>';
          $this->userDetail['last_status'] = '<a href="'.$projects['url'].'" target="_blank">'.$projects['name'].$imgProject.'</a>';
        }

      }elseif($socNet == 'Flickr'){
        //if not id
        if(strpos($socUsername, '@') === false){
          $socUsername = str_replace(' ', '+', $socUsername);
          $socUser = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=dc1985d59dc4b427afefe54c912fae0a&username='.$socUsername.'&format=json&nojsoncallback=1');
          //replace username by id
          if($socUser['stat'] == 'ok')
            $socUsername = $socUser['user']['id'];
        }

        $socUser = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key=dc1985d59dc4b427afefe54c912fae0a&user_id='.urlencode($socUsername).'&format=json&nojsoncallback=1');
        if($socUser['stat'] == 'ok'){
            $socUser = $socUser['person'];
          if(!empty($socUser['realname']['_content']))
            $this->userDetail['soc_username'] = $socUser['realname']['_content'];
          else
            $this->userDetail['soc_username'] = $socUser['username']['_content'];
          if(!empty($socUser['iconserver'])){
            if($socUser['iconserver'] > 0)
              $this->userDetail['photo'] = 'http://farm'.$socUser['iconfarm'].'.staticflickr.com/'.$socUser['iconserver'].'/buddyicons/'.$socUser['nsid'].'.jpg';
            else
              $this->userDetail['photo'] = 'http://www.flickr.com/images/buddyicon.gif';
          }
          if(!empty($socUser['location']['_content']))
            $this->userDetail['location'] = $socUser['location']['_content'];
          if(!empty($socUser['profileurl']['_content']))
            $this->userDetail['soc_url'] = $socUser['profileurl']['_content'];
          if(!empty($socUser['timezone']['label']))
            $this->userDetail['timezone'] = $socUser['timezone']['label'].' '.$socUser['timezone']['offset'];

          $photo = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=dc1985d59dc4b427afefe54c912fae0a&user_id='.urlencode($socUsername).'&format=json&nojsoncallback=1');
          if(($photo['stat'] == 'ok') && !empty($photo['photos']['photo'][0]['id'])){
            $photo = $photo['photos']['photo'][0];
            $this->userDetail['last_photo'] = '<img src="http://farm'.$photo['farm'].'.staticflickr.com/'.$photo['server'].'/'.$photo['id'].'_'.$photo['secret'].'_z.jpg"/><br/>'.$photo['title'];
          }
        }else
          $this->userDetail['soc_username'] =  Yii::t('eauth', "Пользователя с таким именем не существует:").$socUsername;
        //$this->userDetail['about'] = print_r($socUser, true);
      }elseif($socNet == 'YouTube'){
/*        //$userXML = $this->makeRequest('http://gdata.youtube.com/feeds/api/users/'.$socUsername);
        $socUser = $this->xmlToArray(simplexml_load_string($userXML));
*/
        Yii::import('ext.ZendGdata.library.*');
        require_once('Zend/Gdata/YouTube.php');
        require_once('Zend/Gdata/AuthSub.php');

        $yt = new Zend_Gdata_YouTube();
        $yt->setMajorProtocolVersion(2);
        $userProfileEntry = $yt->getUserProfile($socUsername);

        $this->userDetail['soc_username'] = $userProfileEntry->title->text;
        $this->userDetail['photo'] = $userProfileEntry->getThumbnail()->getUrl();
        $this->userDetail['age'] = $userProfileEntry->getAge();
        $this->userDetail['gender'] = $userProfileEntry->getGender();
        $this->userDetail['location'] = $userProfileEntry->getLocation();
        $this->userDetail['school'] = $userProfileEntry->getSchool();
        $this->userDetail['work'] = $userProfileEntry->getCompany();
        $this->userDetail['about'] = $userProfileEntry->getOccupation();

        $videoFeed = $yt->getuserUploads($socUsername);
        $videoEntry = $videoFeed[0];
        $this->userDetail['utube_video_link'] = '<a href="'.$videoEntry->getVideoWatchPageUrl().'" target="_blank">'.$videoEntry->getVideoTitle().'</a>';
        $this->userDetail['utube_video_flash'] = $videoEntry->getFlashPlayerUrl();

      }elseif($socNet == 'Instagram'){
        if(!isset(Yii::app()->user->token) || (Yii::app()->user->service != 'instagram'))
          $this->userDetail['soc_username'] = 'Сначала авторизуйтесь черз Ваш профиль в Instagram';
        else{
        /*
          //Parce html
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, 'http://instagram.com/'.$socUsername);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/../config/ca-bundle.crt');
          $profile = curl_exec($ch);
          $headers = curl_getinfo($ch);
          curl_close($ch);
          $profile = substr($profile, (strpos($profile, ('"username":'.$socUsername))));
          $match = array();
          preg_match('~"id":"[0-9]+"~', $profile, $match);
          if(isset($match[0])){
            $socUsername = str_replace('"id":"', '', $match[0]);
            $socUsername = str_replace('"', '', $socUsername);
          }
        */
          $socUser = $this->makeRequest('https://api.instagram.com/v1/users/search?q='.$socUsername.'&count=1&access_token='.Yii::app()->user->token);
          if(!is_string($socUser)){
            $socUser = $socUser['data'][0];
            if(!empty($socUser['full_name']))
              $this->userDetail['soc_username'] = $socUser['full_name'];
            else
              $this->userDetail['soc_username'] = $socUser['username'];
            $this->userDetail['soc_url'] = 'http://instagram.com/'.$socUser['username'];
            $this->userDetail['photo'] = $socUser['profile_picture'];
            if(!empty($socUser['bio']))
              $this->userDetail['about'] = $socUser['bio'];
            if(!empty($socUser['website']))
              $this->userDetail['url'] = $socUser['website'];
            $userId = $socUser['id'];
            $media = $this->makeRequest('https://api.instagram.com/v1/users/'.$userId.'/media/recent?access_token='.Yii::app()->user->token);
            if(!empty($media['data'][0])){
              $media = $media['data'][0];
              $this->userDetail['last_status'] = '<a href="'.$media['link'].'" target="_blank">'.$media['caption']['text'].'<br/><img src="'.$media['images']['standard_resolution']['url'].'"/></a>';
            }
          }else
            $this->userDetail['soc_username'] = Yii::t('eauth','Пользователя с таким именем не существует:').$socUsername;
        }
      }else{
        $this->userDetail['soc_username'] =  Yii::t('eauth', 'Социальная сеть не поддерживается: ').$socNet;
      }
    return $this->userDetail;
  }

  public function parceSocUrl($socNet, $url){
    $username = $url;
    if($socNet == 'facebook'){
      if((strpos($username, 'facebook.com/') > 0) ||(strpos($username, 'facebook.com/') !== false)){
        $username = substr($username, (strpos($username, 'facebook.com/')+13) );
        if(strpos($username, '?') > 0){
          $username = substr($username, 0, strpos($username, '?'));
        }
        if(strpos($username, '/') > 0){
          $username = substr($username, 0, strpos($username, '/'));
        }
        if(strpos($username, '&') > 0){
          $username = substr($username, 0, strpos($username, '&'));
        }
      }
    }elseif($socNet == 'twitter'){
      if((strpos($username, 'twitter.com/') > 0) ||(strpos($username, 'twitter.com/') !== false)){
        $username = substr($username, (strpos($username, 'twitter.com/')+12) );
        if(strpos($username, '?') > 0){
          $username = substr($username, 0, strpos($username, '?'));
        }
        if(strpos($username, '/') > 0){
          $username = substr($username, 0, strpos($username, '/'));
        }
        if(strpos($username, '&') > 0){
          $username = substr($username, 0, strpos($username, '&'));
        }
      }
    }elseif($socNet == 'google_oauth'){
      if((strpos($username, 'google.com') > 0) ||(strpos($username, 'google.com') !== false)){
        if ((strpos($username, 'google.com/u/0/') > 0) ||(strpos($username, 'google.com/u/0/') !== false)){
          $username = substr($username, (strpos($username, 'google.com/u/0/')+15));
        }
        if ((strpos($username, 'google.com/') > 0) ||(strpos($username, 'google.com/') !== false)){
          $username = substr($username, (strpos($username, 'google.com/')+11));
        }
        if(strpos($username, '?') > 0){
          $username = substr($username, 0, strpos($username, '?'));
        }
        if(strpos($username, '/') > 0){
          $username = substr($username, 0, strpos($username, '/'));
        }
        if(strpos($username, '&') > 0){
          $username = substr($username, 0, strpos($username, '&'));
        }
      }
    }elseif($socNet == 'ВКонтакте'){
      if((strpos($username, 'vk.com/') > 0) ||(strpos($username, 'vk.com/') !== false)){
        $username = substr($username, (strpos($username, 'vk.com/')+7) );
        if(strpos($username, '?') > 0){
          $username = substr($username, 0, strpos($username, '?'));
        }
        if(strpos($username, '/') > 0){
          $username = substr($username, 0, strpos($username, '/'));
        }
        if(strpos($username, '&') > 0){
          $username = substr($username, 0, strpos($username, '&'));
        }
      }
    }elseif($socNet == 'Foursquare'){
      if((strpos($username, 'ru.foursquare.com/user/') > 0) ||(strpos($username, 'ru.foursquare.com/user/') !== false)){
        $username = substr($username, (strpos($username, 'ru.foursquare.com/user/')+23) );
      }
      if((strpos($username, 'foursquare.com') > 0) ||(strpos($username, 'foursquare.com') !== false)){
        $username = substr($username, (strpos($username, 'foursquare.com')+15));
      }
      if(strpos($username, '?') > 0){
        $username = substr($username, 0, strpos($username, '?'));
      }
      if(strpos($username, '/') > 0){
        $username = substr($username, 0, strpos($username, '/'));
      }
      if(strpos($username, '&') > 0){
        $username = substr($username, 0, strpos($username, '&'));
      }
    }elseif($socNet == 'vimeo'){
      if((strpos($username, 'vimeo.com/') > 0) ||(strpos($username, 'vimeo.com/') !== false)){
        $username = substr($username, (strpos($username, 'vimeo.com/')+10) );
        if(strpos($username, '?') > 0){
          $username = substr($username, 0, strpos($username, '?'));
        }
        if(strpos($username, '/') > 0){
          $username = substr($username, 0, strpos($username, '/'));
        }
        if(strpos($username, '&') > 0){
          $username = substr($username, 0, strpos($username, '&'));
        }
      }
    }elseif($socNet == 'Last.fm'){
      if((strpos($username, 'lastfm.ru/user/') > 0) ||(strpos($username, 'lastfm.ru/user/') !== false))
        $username = substr($username, (strpos($username, 'lastfm.ru/user/')+15) );
      if(strpos($username, '?') > 0)
        $username = substr($username, 0, strpos($username, '?'));
      if(strpos($username, '/') > 0)
        $username = substr($username, 0, strpos($username, '/'));
      if(strpos($username, '&') > 0)
        $username = substr($username, 0, strpos($username, '&'));
    }elseif($socNet == 'deviantart'){
      if((strpos($username, 'http://') > 0) ||(strpos($username, 'http://') !== false))
        $username = substr($username, (strpos($username, 'http://')+7) );
      if((strpos($username, 'deviantart.com') > 0) ||(strpos($username, 'deviantart.com') !== false))
        $username = substr($username, 0, (strpos($username, 'deviantart.com')-1) );
      if(strpos($username, 'http://') !== false)
        $username = 'strpos:'.strpos($username, 'http://');
    }elseif($socNet == 'Behance'){
      if((strpos($username, 'behance.net/') > 0) ||(strpos($username, 'behance.net/') !== false))
        $username = substr($username, (strpos($username, 'behance.net/')+ 12));
      $username = $this->rmGetParam($username);
    }elseif($socNet == 'Flickr'){
      if((strpos($username, 'flickr.com/people/') > 0) ||(strpos($username, 'flickr.com/people/') !== false))
        $username = substr($username, (strpos($username, 'flickr.com/people/') + 18));
      if((strpos($username, 'flickr.com/photos/') > 0) ||(strpos($username, 'flickr.com/photos/') !== false))
        $username = substr($username, (strpos($username, 'flickr.com/photos/') + 18));
      $username = $this->rmGetParam($username);
    }elseif($socNet == 'YouTube'){
      if((strpos($username, 'youtube.com/channel/') > 0) ||(strpos($username, 'youtube.com/channel/') !== false))
        $username = substr($username, (strpos($username, 'youtube.com/channel/') + 20));
      if((strpos($username, 'youtube.com/user/') > 0) ||(strpos($username, 'youtube.com/user/') !== false))
        $username = substr($username, (strpos($username, 'youtube.com/user/') + 17));
      $username = $this->rmGetParam($username);
    }elseif($socNet == 'Instagram'){
      if(strpos($username, 'instagram.com/') !== false)
        $username = substr($username, (strpos($username, 'instagram.com/') + 14));
      $username = $this->rmGetParam($username);
    }
    return $username;
  }

  public function rmGetParam($str){
    if(strpos($str, '?') > 0)
      $str = substr($str, 0, strpos($str, '?'));
    if((strpos($str, '/') > 0) && ((strpos($str, 'http://')) === false ))
      $str = substr($str, 0, strpos($str, '/'));
    if(strpos($str, '&') > 0)
      $str = substr($str, 0, strpos($str, '&'));
    return $str;
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
      $curl_result = CJSON::decode($curl_result, true);

    return $curl_result;
  }


  protected function makeRequest($url, $options = array(), $parseJson = true) {
    $ch = $this->initRequest($url, $options);

    $result = curl_exec($ch);
    $headers = curl_getinfo($ch);

    if (curl_errno($ch) > 0)
      throw new CException(curl_error($ch), curl_errno($ch));

    if ($headers['http_code'] != 200) {
      Yii::log(
        'Invalid response http code: '.$headers['http_code'].'.'.PHP_EOL.
        'URL: '.$url.PHP_EOL.
        'Options: '.var_export($options, true).PHP_EOL.
        'Result: '.$result,
        CLogger::LEVEL_ERROR, 'application.extensions.eauth'
      );
      if($headers['http_code'] == 404)
        $result = 'error:'.$headers['http_code'];
      else
        throw new CException(Yii::t('eauth', 'Invalid response http code: {code}.', array('{code}' => $headers['http_code'])), $headers['http_code']);
    }elseif ($parseJson)
      $result = CJSON::decode($result, true);

    curl_close($ch);



    return $result;
  }

  protected function initRequest($url, $options = array()) {
    $ch = curl_init();
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // error with open_basedir or safe mode
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

    if (isset($options['referer']))
      curl_setopt($ch, CURLOPT_REFERER, $options['referer']);

    if (isset($options['headers']))
      curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);

    if (isset($options['query'])) {
      $url_parts = parse_url($url);
      if (isset($url_parts['query'])) {
        $query = $url_parts['query'];
        if (strlen($query) > 0)
          $query .= '&';
        $query .= http_build_query($options['query']);
        $url = str_replace($url_parts['query'], $query, $url);
      }
      else {
        $url_parts['query'] = $options['query'];
        $new_query = http_build_query($url_parts['query']);
        $url .= '?'.$new_query;
      }
    }

    if (isset($options['data'])) {
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
////////
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
    return $ch;
  }

  protected function xmlToArray($element) {
    $array = (array)$element;
    foreach ($array as $key => $value) {
      if (is_object($value))
        $array[$key] = $this->xmlToArray($value);
    }
    return $array;
  }

  public function js_urlencode($str){
    $str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
    $out = '';
    for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++){
      $out .= '%u'.bin2hex(mb_substr($str, $i, 1, 'UTF-16'));
    }
    return $out;
  }

  public function isProfileExists($socNet, $socUsername){
    $answer = false;
  $answer = true;//заглушка


    return $answer;
  }

  public function getSmallIcon($link){
    $answer = '';
    foreach($this->socNetworks as $net){
      if (strpos($link, $net['baseUrl']) !== false){
        $answer = $net['smallIcon'];
        break;
      }
    }
    return $answer;

  }

  public static function isSocLink($link){
    $answer = false;
    $socNetworks = SocInfo::getSocNetworks();
    foreach($socNetworks as $net){
      if (strpos($link, $net['baseUrl']) !== false){
        $answer = true;
        break;
      }
    }
    return $answer;
  }
}