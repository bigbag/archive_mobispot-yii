<?php

class SocInfo extends CFormModel
{

    public $socNet = '';
    public $socUsername = '';
    public $accessToken = '';
    public $userDetail = array();
    public $socNetworks = array();

    public function __construct()
    {
        $this->socNetworks = SocInfo::getSocNetworks();
        Yii::import('webroot.protected.models.soc_content.*');
    }

    public static function getSocNetworks()
    {
        $socNetworks = array();
        $net = array();

        $net['name'] = 'google_oauth';
        $net['baseUrl'] = 'google.com';
        $net['title'] = 'Google+';
        $net['invite'] = Yii::t('eauth', 'Follow me');
        $net['inviteClass'] = '';//'i-soc_g';
        $net['inviteValue'] = '';//'&#xe009;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'google.png';
        $net['contentClass'] = 'GoogleContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'facebook';
        $net['baseUrl'] = 'facebook.com';
        $net['title'] = 'Facebook';
        $net['invite'] = Yii::t('eauth', 'Make friends');
        $net['inviteClass'] = '';//'i-soc-fac';
        $net['inviteValue'] = '';//'&#xe008;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'facebook.png';
        $net['contentClass'] = 'FacebookContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'twitter';
        $net['baseUrl'] = 'twitter.com';
        $net['title'] = 'Twitter';
        $net['invite'] = Yii::t('eauth', 'Follow me');
        $net['inviteClass'] = '';//'i-soc_twi';
        $net['inviteValue'] = '';//'&#xe007';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'twitter.png';
        $net['contentClass'] = 'TwitterContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'vk';
        $net['baseUrl'] = 'vk.com';
        $net['title'] = 'VKontakte';
        $net['invite'] = Yii::t('eauth', 'Follow me');
        $net['inviteClass'] = '';//'i-soc_vk';
        $net['inviteValue'] = '';//'&#xe002;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'vk.png';
        $net['contentClass'] = 'VkContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'linkedin';
        $net['baseUrl'] = 'linkedin.com';
        $net['title'] = 'LinkedIn';
        $net['invite'] = Yii::t('eauth', 'Connect me');
        $net['inviteClass'] = '';//'i-soc_in';
        $net['inviteValue'] = '';//'&#xe005;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'linkedin.png';
        $net['contentClass'] = 'LinkedInContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'foursquare';
        $net['baseUrl'] = 'foursquare.com';
        $net['title'] = 'Foursquare';
        $net['invite'] = Yii::t('eauth', 'Follow me');
        $net['inviteClass'] = '';//'i-soc-fo';
        $net['inviteValue'] = '';//'&#xe00a;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'foursquare.png';
        $net['contentClass'] = 'FoursquareContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'vimeo';
        $net['baseUrl'] = 'vimeo.com';
        $net['title'] = 'Vimeo';
        $net['invite'] = Yii::t('eauth', 'Watch more');
        $net['inviteClass'] = '';//'i-soc_vo';
        $net['inviteValue'] = '';//'&#xe003;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'vimeo.png';
        $net['contentClass'] = 'VimeoContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;
        /*
          $net['name'] = 'Last.fm';
          $net['baseUrl'] = 'lastfm.ru';
          $net['title'] = 'LastFM';
          $net['invite'] = Yii::t('eauth', '');
          $net['inviteClass'] = '';
          $net['inviteValue'] = '';
          $net['note'] = Yii::t('eauth', '');
          $net['smallIcon'] = '';
          $net['contentClass'] = '';
          $net['needAuth'] = true;
          $net['profileHint'] = '';
          $socNetworks[] = $net;
         */
        $net['name'] = 'deviantart';
        $net['baseUrl'] = 'deviantart.com';
        $net['title'] = 'DeviantART';
        $net['invite'] = Yii::t('eauth', 'Follow me');
        $net['inviteClass'] = '';//'i-soc-da';
        $net['inviteValue'] = '';//'&#xe00b;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'deviantart.png';
        $net['contentClass'] = 'DeviantARTContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'Behance';
        $net['baseUrl'] = 'behance.net';
        $net['title'] = 'Behance';
        $net['invite'] = Yii::t('eauth', 'See more');
        $net['inviteClass'] = '';//'i-soc-be';
        $net['inviteValue'] = '';//'&#xe00c;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'behance.png';
        $net['contentClass'] = 'BehanceContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('eauth', 'Please paste the link to your Behance profile here');
        $socNetworks[] = $net;

        /*
          $net['name'] = 'Flickr';
          $net['baseUrl'] = 'flickr.com';
          $net['title'] = 'Flickr';
          $net['invite'] = Yii::t('eauth', '');
          $net['inviteClass'] = '';
          $net['inviteValue'] = '';
          $net['note'] = Yii::t('eauth', '');
          $net['smallIcon'] = '';
          $net['contentClass'] = '';
          $net['needAuth'] = true;
          $net['profileHint'] = '';
          $socNetworks[] = $net;
         */
        $net['name'] = 'YouTube';
        $net['baseUrl'] = 'youtube.com';
        $net['title'] = 'YouTube';
        $net['invite'] = Yii::t('eauth', 'Watch more');
        $net['inviteClass'] = '';//'i-soc_yt';
        $net['inviteValue'] = '';//'&#xe000;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'youtube.png';
        $net['contentClass'] = 'YouTubeContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('eauth', 'Please paste the link to your YouTube profile here');
        $socNetworks[] = $net;

        $net['name'] = 'instagram';
        $net['baseUrl'] = 'instagram.com';
        $net['title'] = 'Instagram';
        $net['invite'] = Yii::t('eauth', 'Follow me');
        $net['inviteClass'] = '';//'i-soc_ing';
        $net['inviteValue'] = '';//'&#xe006;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'instagram.png';
        $net['contentClass'] = 'InstagramContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $socNetworks[] = $net;

        $net['name'] = 'pinterest';
        $net['baseUrl'] = 'pinterest.com';
        $net['title'] = 'Pinterest';
        $net['invite'] = Yii::t('eauth', 'See more pins');
        $net['inviteClass'] = '';//'i-soc-pin';
        $net['inviteValue'] = '';//'&#xe017;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'pinterest.png';
        $net['contentClass'] = 'PinterestContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('eauth', 'Please paste the link to your Pinterest profile here');
        $socNetworks[] = $net;
        
        $net['name'] = 'crunchbase';
        $net['baseUrl'] = 'crunchbase.com';
        $net['title'] = 'CrunchBase';
        $net['invite'] = Yii::t('eauth', 'Watch more');
        $net['inviteClass'] = '';
        $net['inviteValue'] = '';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'crunchbase.png';
        $net['contentClass'] = 'CrunchBaseContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('eauth', 'Please paste the link to your Crunchbase profile here');
        $socNetworks[] = $net;
        
        $net['name'] = 'tumblr';
        $net['baseUrl'] = 'tumblr.com';
        $net['title'] = 'tumblr';
        $net['invite'] = Yii::t('eauth', 'Read more');
        $net['inviteClass'] = '';
        $net['inviteValue'] = '';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'tumblr.png';
        $net['contentClass'] = 'TumblrContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('eauth', 'Please paste the link to your tumblr profile here');
        $socNetworks[] = $net;
        return $socNetworks;
    }

    public function getNetData($link, $discodesId = null, $dataKey = null, $dinamyc = false)
    {
        $this->socNet = '';
        $this->socUsername = '';
        $this->userDetail = array();
        $net = $this->getNetByLink($link);

        if (!empty($net['name']))
        {
            $this->socNet = $net['name'];
            $this->socUsername = $this->parceSocUrl($this->socNet, $link);
            $this->getSocInfo($this->socNet, $this->socUsername, $discodesId, $dataKey);
            $this->userDetail['invite'] = $net['invite'];
            $this->userDetail['inviteClass'] = $net['inviteClass'];
            $this->userDetail['inviteValue'] = $net['inviteValue'];
            $this->userDetail['netName'] = $this->socNet;
        }
        
        if ($dinamyc)
            $this->userDetail['dinamyc'] = true;
        
        if (empty($this->userDetail['soc_url']))
            $this->userDetail['soc_url'] = $link;
        
        return $this->userDetail;
    }

    public function getNetByName($name)
    {
        $answer = array();
        foreach ($this->socNetworks as $net)
        {
            if ($name == $net['name'])
            {
                $answer = $net;
                break;
            }
        }
        return $answer;
    }

    public function getNetByLink($link)
    {
        $answer = array();
        foreach ($this->socNetworks as $net)
        {
            if (strpos($link, $net['baseUrl']) !== false)
            {
                $answer = $net;
                break;
            }
        }
        
        if (empty($answer['name']) and (strpos($link, '.') !== false))
        {
            $tumblrLink = TumblrContent::parseUsername($link);
            $blogInfo = TumblrContent::makeRequest('http://api.tumblr.com/v2/blog/' . $tumblrLink . '/info?api_key='.Yii::app()->eauth->services['tumblr']['key']);
            if (!(is_string($blogInfo) && (strpos($blogInfo, 'error:') !== false)) and isset($blogInfo['response']) and isset($blogInfo['response']['blog']))
                $answer = $this->getNetByName('tumblr');
        }
        
        return $answer;
    }

    public function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $answer = 'ok';

        $net = $this->getNetByLink($link);
        if (isset($net['contentClass']) && strlen($net['contentClass']))
        {
            $class = $net['contentClass'];
            $answer = $class::isLinkCorrect($link, $discodesId, $dataKey);
        }

        return $answer;
    }
    
    public function getSocPatterns()
    {
        $answer = array();
        
        foreach ($this->socNetworks as $net)
        {

            if (!empty($net['baseUrl']))
            {
                $pattern = array();
                $pattern['name'] = $net['name'];
                $pattern['baseUrl'] = $net['baseUrl'];
                $pattern['title'] = $net['title'];
                if (isset(Yii::app()->session[$net['name'] . '_BindByPaste']))
                    $pattern['BindByPaste'] = true;
                else
                    $pattern['BindByPaste'] = false;
                $answer[] = $pattern;
            }
        }
        
        return $answer;
    }
    
    public function isLoggegOn($netName)
    {
        $answer = false;
        
        $net = $this->getNetByName($netName);
        if ($net['needAuth'] == false)
        {
            $answer = true;
        }
        elseif (isset($net['contentClass']) && strlen($net['contentClass']))
        {
            $class = $net['contentClass'];
            $answer = $class::isLoggegByNet();
        }
        elseif(!empty(Yii::app()->session[$net['name'] . '_id']))
            $answer = true;
        
        return $answer;
    }

    public function getSmallIcon($link)
    {
        $answer = '';
        
        $net = $this->getNetByLink($link);
        if (!empty($net['smallIcon']))
            $answer = $net['smallIcon'];
        
        return $answer;
    }
    
    public function getSocInfo($socNet, $socUsername, $discodesId = null, $dataKey = null)
    {
        $this->socNet = $socNet;
        $this->socUsername = $socUsername;
        
        $cachedData = Yii::app()->cache->get('socData_' . md5($socUsername));

        if ($cachedData !== false)
        {
            $this->userDetail = $cachedData;
        }
        else
        {
            $this->userDetail['service'] = $socNet;
            $this->userDetail['UserExists'] = false;
            $socUsername = $this->parceSocUrl($socNet, $socUsername);

            
            if ($socNet == 'linkedin')
            {
                $getProfile = false;
                if (!empty($discodesId) && is_numeric($discodesId))
                {
                    $spot = Spot::model()->findByPk($discodesId);
                    if ($spot)
                    {
                        $socToken = SocToken::model()->findByAttributes(array('user_id' => $spot->user_id, 'type' => 9));
                        if ($socToken)
                        {
                            Yii::import('ext.eoauth.*');
                            $consumer = new OAuthConsumer(Yii::app()->eauth->services['linkedin']['key'], Yii::app()->eauth->services['linkedin']['secret']);
                            $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https://' : 'http://';
                            $callbackUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
                            parse_str($socToken->user_token, $values);
    //              $url = 'http://api.linkedin.com/v1/people/url='.urlencode($socUsername);
                            //$token = new OAuthToken(Yii::app()->eauth->services['linkedin']['token'], Yii::app()->eauth->services['linkedin']['token_secret']);
                            $token = new OAuthToken($values['oauth_token'], $values['oauth_token_secret']);
                            $url = 'http://api.linkedin.com/v1/people/id=' . $socToken->soc_id . ':(id,first-name,last-name,public-profile-url,headline,picture-url,educations,positions)';
                            $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
                            $options = array();
                            $query = null;
                            $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $url, $query);
                            $request->sign_request($signatureMethod, $consumer, $token);
                            $answer = $this->makeRequest($request->to_url(), $options, false);

                            if (strpos($answer, 'error:') === false)
                            {
                                $getProfile = true;
                                $socUser = $this->xmlToArray(simplexml_load_string($answer));

                                $this->userDetail['soc_username'] = $socUser['first-name'] . ' ' . $socUser['last-name'];
                                if (!empty($socUser['picture-url']))
                                    $this->userDetail['photo'] = (string)$socUser['picture-url'];
                                if (!empty($socUser['headline']))
                                    $this->userDetail['sub-line'] = (string)$socUser['headline'];
                                if (!empty($socUser['public-profile-url']))
                                    $this->userDetail['soc_url'] = (string)$socUser['public-profile-url'];
                                $this->userDetail['list'] = array();
                                $this->userDetail['list']['values'] = array();

                                $currentPosition = '';
                                $positionString = '';
                                $educationString = '';
                                if (isset($socUser['positions']) && isset($socUser['positions']['@attributes']) && !empty($socUser['positions']['@attributes']['total']) && isset($socUser['positions']['position']))
                                {
                                    if ($socUser['positions']['@attributes']['total'] > 1)
                                    {
                                        for ($i=0; $i < $socUser['positions']['@attributes']['total']; $i++)
                                        {
                                            if (isset($socUser['positions']['position'][$i]))
                                            {
                                                $position = $this->xmlToArray($socUser['positions']['position'][$i]);
                                                if (isset($position['company']) && !empty($position['company']['name']) && isset($position['is-current']))
                                                {
                                                    if ($position['is-current'] == 'true')
                                                    {
                                                        $currentPosition = $position['company']['name'];
                                                    }
                                                    elseif (!$positionString)
                                                        $positionString = (string)$position['company']['name'];
                                                    else
                                                        $positionString .= ', ' . (string)$position['company']['name'];
                                                
                                                }
                                            }
                                        }
                                    }
                                    elseif (isset($socUser['positions']['position']['company']) && !empty($socUser['positions']['position']['company']['name']) && isset($socUser['positions']['position']['is-current']))
                                    {
                                        if ($socUser['positions']['position']['is-current'] == 'true')
                                            $currentPosition = $socUser['positions']['position']['company']['name'];
                                        else
                                            $positionString = $socUser['positions']['position']['company']['name'];
                                    }
                                }
                                
                                if (isset($socUser['educations']) && isset($socUser['educations']['@attributes']) && !empty($socUser['educations']['@attributes']['total']) && isset($socUser['educations']['education']))
                                {
                                    
                                    if ($socUser['educations']['@attributes']['total'] > 1)
                                    {
                                        for ($i=0; $i < $socUser['educations']['@attributes']['total']; $i++)
                                        {
                                            if (isset($socUser['educations']['education'][$i]))
                                            {
                                                $education = $this->xmlToArray($socUser['educations']['education'][$i]);

                                                if (!empty($education['school-name']))
                                                {
                                                    if (!$educationString)
                                                        $educationString = (string)$education['school-name'];
                                                    else
                                                        $educationString .= ', ' . (string)$education['school-name'];
                                                }
                                            }
                                        }
                                    }
                                    elseif (!empty($socUser['educations']['education']['school-name']))
                                    {
                                        $educationString = $socUser['educations']['education']['school-name'];
                                    }
                                }
                                
                                if ($currentPosition)
                                {
                                    $userPosition = array();
                                    $userPosition['title'] = Yii::t('eauth', "Текущая");
                                    $userPosition['comment'] = $currentPosition;
                                    $this->userDetail['list']['values'][] = $userPosition;
                                }
                                
                                if ($positionString)
                                {
                                    $userPosition = array();
                                    $userPosition['title'] = Yii::t('eauth', "Предыдущие");
                                    $userPosition['comment'] = $positionString;
                                    $this->userDetail['list']['values'][] = $userPosition;
                                }
                                    
                                if ($educationString)
                                {
                                    $userEducation = array();
                                    $userEducation['title'] = Yii::t('eauth', "Образование");
                                    $userEducation['comment'] = $educationString;
                                    $this->userDetail['list']['values'][] = $userEducation;
                                }
                            }
                        }
                    }
                }
                if (!$getProfile)
                {
                    $this->userDetail['last_status'] = $socUsername;
                }

            }
            elseif ($socNet == 'foursquare')
            {
                if (!is_numeric($socUsername))
                {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://foursquare.com/' . $socUsername);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
                    $profile = curl_exec($ch);
                    //$headers = curl_getinfo($ch);
                    curl_close($ch);
                    $match = array();
                    preg_match('~user: {"id":"[0-9]+","firstName":~', $profile, $match);
                    if (isset($match[0]) && (strpos($match[0], 'user: {"id":"') !== false))
                    {
                        $socUsername = str_replace('user: {"id":"', '', $match[0]);
                        $socUsername = str_replace('","firstName":', '', $socUsername);
                    }
                }
                /* search user by twitter nikname - user's authorization needed */
                /*
                  $token = Yii::app()->user->token;
                  $user = (array)$this->makeRequest('https://api.foursquare.com/v2/users/search?twitter='.$socUsername.'&oauth_token='.$token.'&v=20130211', array(), true);
                  $socUser = $user['response']['results']['0'];
                  $socUsername = $socUser['id'];
                 */

                $socUser = $this->makeCurlRequest('https://api.foursquare.com/v2/users/' . $socUsername . '?client_id=' . Yii::app()->eauth->services['foursquare']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['foursquare']['client_secret'] . '&v=20130211');
                $socUser = $socUser['response']['user'];

                if (!empty($socUser['firstName']))
                {
                    if (!empty($socUser['lastName']))
                        $this->userDetail['soc_username'] = $socUser['firstName'] . ' ' . $socUser['lastName'];
                    else
                        $this->userDetail['soc_username'] = $socUser['firstName'];
                }
                else
                    $this->userDetail['soc_username'] = $socUser['id'];
                if (isset($socUser['photo']) && !empty($socUser['photo']['prefix']) && isset($socUser['photo']['suffix']))
                    $this->userDetail['photo'] = $socUser['photo']['prefix'] . '100x100' . $socUser['photo']['suffix'];


                //Последний чекин
                if (!empty($socUser['id']))
                {
                    $user = User::model()->findByAttributes(array(
                        'foursquare_id' => $socUser['id']
                    ));

                    if ($user && !empty($user->foursquare_token))
                    {
                        $checkins = $this->makeCurlRequest('https://api.foursquare.com/v2/users/' . $socUser['id'] . '/checkins?limit=250&sort=newestfirst&oauth_token=' . $user->foursquare_token . '&v=20130211');
                        if (isset($checkins['response']) && isset($checkins['response']['checkins']) && isset($checkins['response']['checkins']['items']))
                        {
                            unset($lastCheckin);
                            $i = 0;

                            while (!isset($lastCheckin))
                            {
                                if (isset($checkins['response']['checkins']['items'][$i]) && isset($checkins['response']['checkins']['items'][$i]['type']) && ($checkins['response']['checkins']['items'][$i]['type'] == 'checkin') && isset($checkins['response']['checkins']['items'][$i]['venue']) && isset($checkins['response']['checkins']['items'][$i]['venue']['name']) && !isset($checkins['response']['checkins']['items'][$i]['private']))
                                {
                                    $lastCheckin = $checkins['response']['checkins']['items'][$i];
                                }
                                elseif (!isset($checkins['response']['checkins']['items'][$i]))
                                {
                                    $lastCheckin = 'no';
                                }
                                else
                                    $i++;
                            }

                            if ($lastCheckin != 'no')
                            {
                                $this->userDetail['venue_name'] = $lastCheckin['venue']['name'];
                                if (!empty($lastCheckin['shout']))
                                    $this->userDetail['checkin_shout'] = $lastCheckin['shout'];
                                if (isset($lastCheckin['venue']['location']) && isset($lastCheckin['venue']['location']['address']))
                                    $this->userDetail['venue_address'] = $lastCheckin['venue']['location']['address'];
                                if (isset($lastCheckin['createdAt']) && isset($lastCheckin['timeZoneOffset']))
                                {
                                    $dateDiff = time() - $lastCheckin['createdAt'] + $lastCheckin['timeZoneOffset'];
                                    $this->userDetail['sub-time'] = SocContentBase::timeDiff($dateDiff);
                                    $this->userDetail['checkin_date'] = date('F j, Y', ($lastCheckin['createdAt'] + $lastCheckin['timeZoneOffset']));
                                }
                                if (isset($lastCheckin['photos']) && isset($lastCheckin['photos']['items']) && isset($lastCheckin['photos']['items'][0]) && isset($lastCheckin['photos']['items'][0]['prefix']) && isset($lastCheckin['photos']['items'][0]['suffix']) && isset($lastCheckin['photos']['items'][0]['width']) && isset($lastCheckin['photos']['items'][0]['height']))
                                {
                                    $this->userDetail['checkin_photo'] = $lastCheckin['photos']['items'][0]['prefix'] . $lastCheckin['photos']['items'][0]['width'] . 'x' . $lastCheckin['photos']['items'][0]['height'] . $lastCheckin['photos']['items'][0]['suffix'];
                                }
                            }
                        }
                    }
                }
                //Последний бейдж
                $badges = $this->makeCurlRequest('https://api.foursquare.com/v2/users/' . $socUsername . '/badges?client_id=' . Yii::app()->eauth->services['foursquare']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['foursquare']['client_secret'] . '&v=20130211');
                $last_badge = array();
                if (isset($badges['response']) && isset($badges['response']['badges']))
                {
                    foreach ($badges['response']['badges'] as $badge)
                    {
                        if (isset($badge['unlocks']) && isset($badge['unlocks'][0]) && !isset($last_badge['id']))
                        {
                            $last_badge['id'] = $badge['id'];
                            if (isset($badge['image']) && isset($badge['image']['prefix']) && isset($badge['image']['sizes']) && isset($badge['image']['sizes']['1']) && isset($badge['image']['name']))
                                $last_badge['image'] = $badge['image']['prefix'] . $badge['image']['sizes']['1'] . $badge['image']['name'];
                            if (!empty($badge['name']))
                                $last_badge['name'] = $badge['name'];
                            if (isset($badge['unlocks']) && isset($badge['unlocks'][0]) && isset($badge['unlocks'][0]['checkins']) && isset($badge['unlocks'][0]['checkins'][0]) && isset($badge['unlocks'][0]['checkins'][0]['createdAt']) && isset($badge['unlocks'][0]['checkins'][0]['timeZoneOffset']))
                            {
                                $last_badge['date'] = $badge['unlocks'][0]['checkins'][0]['createdAt'];
                                $last_badge['timeZoneOffset'] = $badge['unlocks'][0]['checkins'][0]['timeZoneOffset'];
                            }
                            if (!empty($badge['description']))
                                $last_badge['description'] = $badge['description'];
                            if (!empty($badge['badgeText']))
                                $last_badge['badgeText'] = $badge['badgeText'];
                            if (isset($badge['unlocks']) && isset($last_badge['date']))
                            {
                                foreach ($badge['unlocks'] as $unlock)
                                {
                                    if (isset($unlock['checkins']))
                                    {
                                        foreach ($unlock['checkins'] as $checkin)
                                        {
                                            if (isset($checkin['createdAt']) && isset($checkin['timeZoneOffset']) && ($checkin['createdAt'] > $last_badge['date']))
                                            {
                                                $last_badge['date'] = $checkin['createdAt'];
                                                $last_badge['timeZoneOffset'] = $checkin['timeZoneOffset'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            if (isset($badge['unlocks']))
                            {
                                foreach ($badge['unlocks'] as $unlock)
                                {
                                    if (isset($unlock['checkins']))
                                    {
                                        foreach ($unlock['checkins'] as $checkin)
                                        {
                                            if ($checkin['createdAt'] > $last_badge['date'])
                                            {
                                                $last_badge['id'] = $badge['id'];
                                                $last_badge['image'] = $badge['image']['prefix'] . $badge['image']['sizes']['1'] . $badge['image']['name'];
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
                    }
                }
                if (!empty($last_badge['id']) && !empty($last_badge['image']))
                {
                    $this->userDetail['last_img'] = $last_badge['image'];
                    $this->userDetail['last_img_href'] = 'https://foursquare.com/user/' . $socUsername . '/badge/' . $last_badge['id'];
                    if (!empty($last_badge['name']))
                    {
                        $this->userDetail['last_img_msg'] = $last_badge['name'];
                        if (!empty($last_badge['date']) && isset($last_badge['timeZoneOffset']))
                            $this->userDetail['last_img_msg'] .= '<br/>' . date('F j, Y', ($last_badge['date'] + $last_badge['timeZoneOffset']));
                    }
                    if (!empty($last_badge['description']))
                        $this->userDetail['last_img_story'] = $last_badge['description'];
                }
                /*
                  $this->userDetail['url'] = 'https://foursquare.com/user/'.$socUser['id'];
                  if (!empty($socUser['gender']))
                  $this->userDetail['gender'] = $socUser['gender'];
                  if (!empty($socUser['homeCity']))
                  $this->userDetail['location'] = $socUser['homeCity'];
                  if (!empty($socUser['bio']))
                  $this->userDetail['about'] = $socUser['bio'];
                  $tips = $this->makeCurlRequest('https://api.foursquare.com/v2/lists/'.$socUsername.'/tips?client_id='.Yii::app()->eauth->services['foursquare']['client_id'].'&client_secret='.Yii::app()->eauth->services['foursquare']['client_secret'].'&v=20130211');
                  if (!empty($tips['response']['list']['listItems']['items']['0']))
                  $this->userDetail['last_tip'] = '"<a href="'.$tips['response']['list']['listItems']['items']['0']['venue']['canonicalUrl'].'">'.$tips['response']['list']['listItems']['items']['0']['venue']['name'].'</a> :'.$tips['response']['list']['listItems']['items']['0']['tip']['text'].'"';
                 */
            }elseif ($socNet == 'vimeo')
            {
                $socUser = $this->makeCurlRequest('http://vimeo.com/api/v2/' . $socUsername . '/info.json');
                if (!is_string($socUser) && isset($socUser['id']))
                {
                    if (!empty($socUser['display_name']))
                        $this->userDetail['soc_username'] = $socUser['display_name'];
                    if (!empty($socUser['profile_url']))
                        $this->userDetail['soc_url'] = $socUser['profile_url'];
                    if (!empty($socUser['profile_url']) && !empty($socUser['display_name']))
                        $this->userDetail['sub-line'] = ' from <a href="'. $socUser['profile_url'] .'">' 
                            . $socUser['display_name'] . '</a> on <a href="http://vimeo.com">Vimeo</a> </span>';
                    
                    if (!empty($socUser['portrait_medium']))
                        $this->userDetail['photo'] = $socUser['portrait_medium'];
                    elseif (!empty($socUser['portrait_small']))
                        $this->userDetail['photo'] = $socUser['portrait_small'];
                    $video = $this->makeCurlRequest('http://vimeo.com/api/v2/' . $socUsername . '/videos.json');

                    if (isset($video[0]) && isset($video[0]['id']))
                    {
                        $this->userDetail['vimeo_last_video'] = $video[0]['id'];
                        if (isset($video[0]['video_stats_number_of_plays']))
                            $this->userDetail['vimeo_last_video_counter'] = $video[0]['video_stats_number_of_plays'];
                        elseif (isset($video[0]['stats_number_of_plays']))
                            $this->userDetail['vimeo_last_video_counter'] = $video[0]['stats_number_of_plays'];
                        if (!empty($video[0]['title']))
                            $this->userDetail['soc_username'] = $video[0]['title'];
                    }
                    if (isset($video[0]['width']) && isset($video[0]['height']))
                    {
                        $this->userDetail['vimeo_video_width'] = $video[0]['width'];
                        $this->userDetail['vimeo_video_height'] = $video[0]['height'];
                    }
                }
                else
                {
                    $video = $this->makeCurlRequest('http://vimeo.com/api/v2/video/' . $socUsername . '.json');
     
                    if (!is_string($video) && isset($video[0]))
                    {
                        if (!empty($video[0]['title']))
                            $this->userDetail['soc_username'] = $video[0]['title'];
                        elseif (!empty($video[0]['user_name']))
                            $this->userDetail['soc_username'] = $video[0]['user_name'];
                        if (!empty($video[0]['url']))
                            $this->userDetail['soc_url'] = $video[0]['url'];
                        if (!empty($video[0]['user_url']) && !empty($video[0]['user_name']))
                            $this->userDetail['sub-line'] = ' from <a href="'. $video[0]['user_url'] .'">' 
                                . $video[0]['user_name'] . '</a> on <a href="http://vimeo.com">Vimeo</a> </span>';
                        if (!empty($video[0]['user_portrait_medium']))
                            $this->userDetail['photo'] = $video[0]['user_portrait_medium'];
                        elseif (!empty($video[0]['user_portrait_small']))
                            $this->userDetail['photo'] = $video[0]['user_portrait_small'];
                        $this->userDetail['vimeo_last_video'] = $socUsername;
                        if (isset($video[0]['video_stats_number_of_plays']))
                            $this->userDetail['vimeo_last_video_counter'] = $video[0]['video_stats_number_of_plays'];
                        elseif (isset($video[0]['stats_number_of_plays']))
                            $this->userDetail['vimeo_last_video_counter'] = $video[0]['stats_number_of_plays'];
                        if (isset($video[0]['width']) && isset($video[0]['height']))
                        {
                            $this->userDetail['vimeo_video_width'] = $video[0]['width'];
                            $this->userDetail['vimeo_video_height'] = $video[0]['height'];
                        }
                    }
                    else
                    {
                        $this->userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
                    }
                }
            }
            elseif ($socNet == 'Last.fm')
            {
                $socUser = $this->makeCurlRequest('http://ws.audioscrobbler.com/2.0/?method=user.getinfo&user=' . $socUsername . '&api_key=6a76cdf194415b30b2f94a1aadb38b3e&format=json');
                $socUser = $socUser['user'];
                if (!empty($socUser['realname']))
                    $this->userDetail['soc_username'] = $socUser['realname'];
                else
                    $this->userDetail['soc_username'] = $socUser['name'];
                if (!empty($socUser['image'][1]))
                    $this->userDetail['photo'] = $socUser['image'][1]['#text'];
                if (!empty($socUser['url']))
                    $this->userDetail['soc_url'] = $socUser['url'];
                if (!empty($socUser['country']))
                    $this->userDetail['location'] = $socUser['country'];
                if (!empty($socUser['age']))
                    $this->userDetail['age'] = $socUser['age'];
                if (!empty($socUser['gender']))
                    $this->userDetail['gender'] = $socUser['gender'];
            }
            elseif ($socNet == 'Flickr')
            {
                //if not id
                if (strpos($socUsername, '@') === false)
                {
                    $socUsername = str_replace(' ', '+', $socUsername);
                    $socUser = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=dc1985d59dc4b427afefe54c912fae0a&username=' . $socUsername . '&format=json&nojsoncallback=1');
                    //replace username by id
                    if ($socUser['stat'] == 'ok')
                        $socUsername = $socUser['user']['id'];
                }

                $socUser = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key=dc1985d59dc4b427afefe54c912fae0a&user_id=' . urlencode($socUsername) . '&format=json&nojsoncallback=1');
                if ($socUser['stat'] == 'ok')
                {
                    $socUser = $socUser['person'];
                    if (!empty($socUser['realname']['_content']))
                        $this->userDetail['soc_username'] = $socUser['realname']['_content'];
                    else
                        $this->userDetail['soc_username'] = $socUser['username']['_content'];
                    if (!empty($socUser['iconserver']))
                    {
                        if ($socUser['iconserver'] > 0)
                            $this->userDetail['photo'] = 'http://farm' . $socUser['iconfarm'] . '.staticflickr.com/' . $socUser['iconserver'] . '/buddyicons/' . $socUser['nsid'] . '.jpg';
                        else
                            $this->userDetail['photo'] = 'http://www.flickr.com/images/buddyicon.gif';
                    }
                    if (!empty($socUser['location']['_content']))
                        $this->userDetail['location'] = $socUser['location']['_content'];
                    if (!empty($socUser['profileurl']['_content']))
                        $this->userDetail['soc_url'] = $socUser['profileurl']['_content'];
                    if (!empty($socUser['timezone']['label']))
                        $this->userDetail['timezone'] = $socUser['timezone']['label'] . ' ' . $socUser['timezone']['offset'];

                    $photo = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=dc1985d59dc4b427afefe54c912fae0a&user_id=' . urlencode($socUsername) . '&format=json&nojsoncallback=1');
                    if (($photo['stat'] == 'ok') && !empty($photo['photos']['photo'][0]['id']))
                    {
                        $photo = $photo['photos']['photo'][0];
                        $this->userDetail['last_photo'] = '<img src="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_z.jpg"/><br/>' . $photo['title'];
                    }
                }
                else
                    $this->userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
                //$this->userDetail['about'] = print_r($socUser, true);
            }elseif ($socNet == 'YouTube')
            {
                //$userXML = $this->makeRequest('http://gdata.youtube.com/feeds/api/users/'.$socUsername);
                $username = '';
                if ((strpos($socUsername, 'youtube.com/channel/') > 0) || (strpos($socUsername, 'youtube.com/channel/') !== false))
                    $username = substr($socUsername, (strpos($socUsername, 'youtube.com/channel/') + 20));
                if ((strpos($socUsername, 'youtube.com/user/') > 0) || (strpos($socUsername, 'youtube.com/user/') !== false))
                    $username = substr($socUsername, (strpos($socUsername, 'youtube.com/user/') + 17));
                if (strlen($username) > 0)
                {
                    $username = $this->rmGetParam($username);

                    Yii::import('ext.ZendGdata.library.*');
                    require_once('Zend/Gdata/YouTube.php');
                    require_once('Zend/Gdata/AuthSub.php');

                    $yt = new Zend_Gdata_YouTube();
                    $yt->setMajorProtocolVersion(2);
                    try
                    {
                        $userProfileEntry = $yt->getUserProfile($username);

                        //$this->userDetail['soc_username'] = $userProfileEntry->title->text;
                        $this->userDetail['photo'] = $userProfileEntry->getThumbnail()->getUrl();
                        /*
                        $this->userDetail['age'] = $userProfileEntry->getAge();
                        $this->userDetail['gender'] = $userProfileEntry->getGender();
                        $this->userDetail['location'] = $userProfileEntry->getLocation();
                        $this->userDetail['school'] = $userProfileEntry->getSchool();
                        $this->userDetail['work'] = $userProfileEntry->getCompany();
                        $this->userDetail['about'] = $userProfileEntry->getOccupation();
                        */
                        
                        $videoFeed = $yt->getuserUploads($username);

                        if (isset($videoFeed[0]))
                        {
                            $videoEntry = $videoFeed[0];
                            $this->userDetail['ytube_video_link'] = '<a href="' . $videoEntry->getVideoWatchPageUrl() . '" target="_blank">' . $videoEntry->getVideoTitle() . '</a>';
                            $this->userDetail['ytube_video_flash'] = $videoEntry->getFlashPlayerUrl();
                            $this->userDetail['ytube_video_view_count'] = $videoEntry->getVideoViewCount();

                            $videoThumbnails = $videoEntry->getVideoThumbnails();
                            if (isset($videoThumbnails[0]) && isset($videoThumbnails[0]['width']) && isset($videoThumbnails[0]['height']))
                            {
                                $this->userDetail['ytube_video_rel'] = $videoThumbnails[0]['width'] / $videoThumbnails[0]['height'];
                            }
                        }
                    } catch (Exception $e)
                    {
                        $this->userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
                    }
                }
                else
                {
                    $videoId = '';
                    if ((strpos($socUsername, 'youtube.com') !== false) && (strpos($socUsername, 'watch?v=') !== false))
                    {
                        $videoId = substr($socUsername, (strpos($socUsername, 'watch?v=') + 8));

                        Yii::import('ext.ZendGdata.library.*');
                        require_once('Zend/Gdata/YouTube.php');
                        require_once('Zend/Gdata/AuthSub.php');

                        $yt = new Zend_Gdata_YouTube();
                        $yt->setMajorProtocolVersion(2);
                        try
                        {
                            $videoEntry = $yt->getVideoEntry($videoId);
                            $this->userDetail['ytube_video_link'] = '<a href="' . $videoEntry->getVideoWatchPageUrl() . '" target="_blank">' . $videoEntry->getVideoTitle() . '</a>';
                            $this->userDetail['ytube_video_flash'] = $videoEntry->getFlashPlayerUrl();
                            $this->userDetail['ytube_video_view_count'] = $videoEntry->getVideoViewCount();

                            $videoThumbnails = $videoEntry->getVideoThumbnails();
                            if (isset($videoThumbnails[0]))
                            {
                                $this->userDetail['ytube_video_rel'] = $videoThumbnails[0]['width'] / $videoThumbnails[0]['height'];
                            }
                        } catch (Exception $e)
                        {
                            $this->userDetail['soc_username'] = Yii::t('eauth', "This post doesn't exist:") . $socUsername;
                        }
                    }
                }
                $this->userDetail['avatar_before_mess_body'] = true;

            }
            elseif ($socNet == 'instagram')
            {
                $socUser = $this->makeRequest('https://api.instagram.com/v1/users/search?q=' . $socUsername . '&count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
                if (!is_string($socUser) && isset($socUser['data']) && isset($socUser['data'][0]))
                {
                    $socUser = $socUser['data'][0];
                    /* if(!empty($socUser['full_name']))
                      $this->userDetail['soc_username'] = $socUser['full_name'];
                      elseif(!empty($socUser['username']))
                      $this->userDetail['soc_username'] = $socUser['username'];
                     */
                    if (!empty($socUser['username']))
                        $this->userDetail['soc_url'] = 'http://instagram.com/' . $socUser['username'];
                    /*  if(!empty($socUser['profile_picture']))
                      $this->userDetail['photo'] = $socUser['profile_picture'];
                     */

                    $techSoc = SocToken::model()->findByAttributes(array(
                        'type' => 10,
                        'is_tech' => true
                    ));

                    if ($techSoc && isset($socUser['id']))
                    {
                        $media = $this->makeRequest('https://api.instagram.com/v1/users/' . $socUser['id'] . '/media/recent?count=1&access_token=' . $techSoc->user_token);
  
                        if (isset($media['data']) && isset($media['data'][0]))
                        {
                            if (!empty($media['data'][0]['user']['profile_picture']))
                                $this->userDetail['photo'] = $media['data'][0]['user']['profile_picture'];
                            if (!empty($media['data'][0]['user']['full_name']))
                                $this->userDetail['soc_username'] = $media['data'][0]['user']['full_name'];
                            elseif (!empty($media['data'][0]['user']['username']))
                                $this->userDetail['soc_username'] = $media['data'][0]['user']['username'];
                            if (isset($media['data'][0]['location']) && !empty($media['data'][0]['location']['name']))
                                $this->userDetail['sub-line'] = '<span class="icon">&#xe018;</span>' . $media['data'][0]['location']['name'];
                            if (!empty($media['data'][0]['created_time']))
                            {
                                $dateDiff = time() - (int)$media['data'][0]['created_time'];
                                $this->userDetail['sub-time'] = SocContentBase::timeDiff($dateDiff);
                            }

                            if (isset($media['data'][0]['images']) && isset($media['data'][0]['images']['standard_resolution']) && !empty($media['data'][0]['images']['standard_resolution']['url']))
                                $this->userDetail['last_img'] = $media['data'][0]['images']['standard_resolution']['url'];
                            elseif (isset($media['data'][0]['images']) && isset($media['data'][0]['images']['thumbnail']) && !empty($media['data'][0]['images']['thumbnail']['url']))
                                $this->userDetail['last_img'] = $media['data'][0]['images']['thumbnail']['url'];
                            if (isset($media['data'][0]['caption']) && !empty($media['data'][0]['caption']['text']))
                                $this->userDetail['last_img_msg'] = $media['data'][0]['caption']['text'];
                            if (!empty($media['data'][0]['link']))
                                $this->userDetail['last_img_href'] = $media['data'][0]['link'];
                        }
                    }
                    /*
                      $user=User::model()->findByAttributes(array(
                      'instagram_id'=>$socUser['id']
                      ));
                      if($user && strlen($user->instagram_media_id > 0)){
                      $media = $this->makeRequest('https://api.instagram.com/v1/media/'.$user->instagram_media_id.'?client_id='.Yii::app()->eauth->services['instagram']['client_id']);
                      if(isset($media['data'])){
                      if(isset($media['data']['images']) && isset($media['data']['images']['standard_resolution']) && !empty($media['data']['images']['standard_resolution']['url']))
                      $this->userDetail['last_img'] = $media['data']['images']['standard_resolution']['url'];
                      elseif(isset($media['data']['images']) && isset($media['data']['images']['thumbnail']) && !empty($media['data']['images']['thumbnail']['url']))
                      $this->userDetail['last_img'] = $media['data']['images']['thumbnail']['url'];
                      if(isset($media['data']['caption']) && !empty($media['data']['caption']['text']))
                      $this->userDetail['last_img_msg'] = $media['data']['caption']['text'];
                      if(!empty($media['data']['link']))
                      $this->userDetail['last_img_href'] = $media['data']['link'];
                      }
                      }
                     */
                }
                else
                    $this->userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

            }
            else
            {
                $net = $this->getNetByLink($socUsername);
                if (isset($net['contentClass']) && strlen($net['contentClass']))
                {
                    $class = $net['contentClass'];
                    $this->userDetail = $class::getContent($socUsername, $discodesId, $dataKey);
                }
                else
                    $this->userDetail['soc_username'] = Yii::t('eauth', 'This social network is not supported by Mobispot: ') . $socNet;
            }
            
            Yii::app()->cache->set('socData_' . md5($socUsername), $this->userDetail, 120);
        }
   
        return $this->userDetail;
    }

    public function parceSocUrl($socNet, $url)
    {
        $username = $url;
        if ($socNet == 'foursquare')
        {
            if (strpos($username, 'foursquare.com/user/') !== false)
            {
                $username = substr($username, (strpos($username, 'foursquare.com/user/') + 20));
            }
            if (strpos($username, 'foursquare.com') !== false)
            {
                $username = substr($username, (strpos($username, 'foursquare.com') + 15));
            }
            if (strpos($username, '?') > 0)
            {
                $username = substr($username, 0, strpos($username, '?'));
            }
            if (strpos($username, '/') > 0)
            {
                $username = substr($username, 0, strpos($username, '/'));
            }
            if (strpos($username, '&') > 0)
            {
                $username = substr($username, 0, strpos($username, '&'));
            }
        }
        elseif ($socNet == 'vimeo')
        {
            if ((strpos($username, 'vimeo.com/') > 0) || (strpos($username, 'vimeo.com/') !== false))
            {
                $username = substr($username, (strpos($username, 'vimeo.com/') + 10));
                if (strpos($username, '?') > 0)
                {
                    $username = substr($username, 0, strpos($username, '?'));
                }
                if (strpos($username, '/') > 0)
                {
                    $username = substr($username, 0, strpos($username, '/'));
                }
                if (strpos($username, '&') > 0)
                {
                    $username = substr($username, 0, strpos($username, '&'));
                }
            }
        }
        elseif ($socNet == 'Last.fm')
        {
            if ((strpos($username, 'lastfm.ru/user/') > 0) || (strpos($username, 'lastfm.ru/user/') !== false))
                $username = substr($username, (strpos($username, 'lastfm.ru/user/') + 15));
            if (strpos($username, '?') > 0)
                $username = substr($username, 0, strpos($username, '?'));
            if (strpos($username, '/') > 0)
                $username = substr($username, 0, strpos($username, '/'));
            if (strpos($username, '&') > 0)
                $username = substr($username, 0, strpos($username, '&'));
        }
        elseif ($socNet == 'Flickr')
        {
            if ((strpos($username, 'flickr.com/people/') > 0) || (strpos($username, 'flickr.com/people/') !== false))
                $username = substr($username, (strpos($username, 'flickr.com/people/') + 18));
            if ((strpos($username, 'flickr.com/photos/') > 0) || (strpos($username, 'flickr.com/photos/') !== false))
                $username = substr($username, (strpos($username, 'flickr.com/photos/') + 18));
            $username = $this->rmGetParam($username);
        }elseif ($socNet == 'YouTube')
        {
            /*
              if((strpos($username, 'youtube.com/channel/') > 0) ||(strpos($username, 'youtube.com/channel/') !== false))
              $username = substr($username, (strpos($username, 'youtube.com/channel/') + 20));
              if((strpos($username, 'youtube.com/user/') > 0) ||(strpos($username, 'youtube.com/user/') !== false))
              $username = substr($username, (strpos($username, 'youtube.com/user/') + 17));
              $username = $this->rmGetParam($username);
             */
        }
        elseif ($socNet == 'instagram')
        {
            if (strpos($username, 'instagram.com/') !== false)
                $username = substr($username, (strpos($username, 'instagram.com/') + 14));
            $username = $this->rmGetParam($username);
        }
        return $username;
    }

    public function rmGetParam($str)
    {
        if (strpos($str, '?') > 0)
            $str = substr($str, 0, strpos($str, '?'));
        if ((strpos($str, '/') > 0) && ((strpos($str, 'http://')) === false ))
            $str = substr($str, 0, strpos($str, '/'));
        if (strpos($str, '&') > 0)
            $str = substr($str, 0, strpos($str, '&'));
        return $str;
    }

    public function makeCurlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');


        $curl_result = curl_exec($ch);
        $headers = curl_getinfo($ch);
        //curl_error($ch);
        curl_close($ch);

        if ($headers['http_code'] != 200)
            $result = 'error:' . $headers['http_code'];
        else
            $curl_result = CJSON::decode($curl_result, true);

        return $curl_result;
    }

    protected function makeRequest($url, $options = array(), $parseJson = true)
    {
        $ch = $this->initRequest($url, $options);

        $result = curl_exec($ch);
        $headers = curl_getinfo($ch);

        if (curl_errno($ch) > 0)
            throw new CException(curl_error($ch), curl_errno($ch));

        if ($headers['http_code'] != 200)
        {
            Yii::log(
                    'Invalid response http code: ' . $headers['http_code'] . '.' . PHP_EOL .
                    'URL: ' . $url . PHP_EOL .
                    'Options: ' . var_export($options, true) . PHP_EOL .
                    'Result: ' . $result, CLogger::LEVEL_ERROR, 'application.extensions.eauth'
            );
            $result = 'error:' . $headers['http_code'];
        }
        elseif ($parseJson)
            $result = CJSON::decode($result, true);
        curl_close($ch);

        return $result;
    }

    protected function initRequest($url, $options = array())
    {
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // error with open_basedir or safe mode
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

        if (isset($options['referer']))
            curl_setopt($ch, CURLOPT_REFERER, $options['referer']);

        if (isset($options['headers']))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);

        if (isset($options['query']))
        {
            $url_parts = parse_url($url);
            if (isset($url_parts['query']))
            {
                $query = $url_parts['query'];
                if (strlen($query) > 0)
                    $query .= '&';
                $query .= http_build_query($options['query']);
                $url = str_replace($url_parts['query'], $query, $url);
            }
            else
            {
                $url_parts['query'] = $options['query'];
                $new_query = http_build_query($url_parts['query']);
                $url .= '?' . $new_query;
            }
        }

        if (isset($options['data']))
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
////////
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
        return $ch;
    }

    protected function xmlToArray($element)
    {
        $array = (array) $element;
        foreach ($array as $key => $value)
        {
            if (is_object($value))
                $array[$key] = $this->xmlToArray($value);
        }
        return $array;
    }

    public function js_urlencode($str)
    {
        $str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
        $out = '';
        for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++)
        {
            $out .= '%u' . bin2hex(mb_substr($str, $i, 1, 'UTF-16'));
        }
        return $out;
    }

    public function contentNeedSave($link){
        $answer = false;

        $net = $this->getNetByLink($link);
        if (isset($net['contentClass']) && strlen($net['contentClass']))
        {
            $class = $net['contentClass'];
            $answer = $class::contentNeedSave($link);
        }
        return $answer;
    }

}