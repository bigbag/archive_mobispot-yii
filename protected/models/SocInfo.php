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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_GOOGLE;
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
        $net['sharingType'] = array(Loyalty::FACEBOOK_LIKE, Loyalty::FACEBOOK_SHARE);
        $net['tokenType'] = SocToken::TYPE_FACEBOOK;
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
        $net['sharingType'] = array(Loyalty::TWITTER_SHARE, Loyalty::TWITTER_RETWIT, Loyalty::TWITTER_READING, Loyalty::TWITTER_HASHTAG);
        $net['tokenType'] = SocToken::TYPE_TWITTER;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_YOUTUBE;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_LINKEDIN;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_FOURSQUARE;
        $socNetworks[] = $net;

        $net['name'] = 'vimeo';
        $net['baseUrl'] = 'vimeo.com';
        $net['title'] = 'Vimeo';
        $net['invite'] = Yii::t('eauth', 'Follow me'); //Yii::t('eauth', 'Watch more');
        $net['inviteClass'] = '';//'i-soc_vo';
        $net['inviteValue'] = '';//'&#xe003;';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'vimeo.png';
        $net['contentClass'] = 'VimeoContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_VIMEO;
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
          $net['sharingType'] = array();
          $net['tokenType'] = SocToken::;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_DEVIANTART;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_BEHANCE;
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
          $net['tokenType'] = SocToken::;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_YOUTUBE;
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
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_INSTAGRAM;
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
        $net['sharingType'] = array();
        $net['tokenType'] = null;
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
        $net['sharingType'] = array();
        $net['tokenType'] = null;
        $socNetworks[] = $net;
        
        $net['name'] = 'tumblr';
        $net['baseUrl'] = 'tumblr.com';
        $net['title'] = 'tumblr';
        $net['invite'] = Yii::t('eauth', 'Follow me'); //'Read more');
        $net['inviteClass'] = '';
        $net['inviteValue'] = '';
        $net['note'] = Yii::t('eauth', '');
        $net['smallIcon'] = 'tumblr.png';
        $net['contentClass'] = 'TumblrContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('eauth', 'Please paste the link to your tumblr profile here');
        $socNetworks[] = $net;
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_TUMBLR;
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
            if (empty($this->userDetail['invite']))
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
        $name = $this->mergeMobile($name);
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
            if (!empty(Yii::app()->eauth->services['tumblr']))
            {
               $blogInfo = TumblrContent::makeRequest('http://api.tumblr.com/v2/blog/' . $tumblrLink . '/info?api_key='.Yii::app()->eauth->services['tumblr']['key']);
            if (!(is_string($blogInfo) && (strpos($blogInfo, 'error:') !== false)) and isset($blogInfo['response']) and isset($blogInfo['response']['blog']))
                $answer = $this->getNetByName('tumblr'); 
            }
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
    
    public function isLoggegOn($netName, $checkNeed = true)
    {
        $answer = false;
        
        $net = $this->getNetByName($netName);
        if ($checkNeed && $net['needAuth'] == false)
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

        $uncheck = array('html', 'list', 'list2', 'follow_button');
        foreach($this->userDetail as $socKey => $socValue)
        {
            if (!is_array($socValue) && !in_array($socKey, $uncheck))
                $this->userDetail[$socKey] =  strip_tags((string)$socValue, '<div><p><br><hr><a><b><q><i><s><img><span><ui><ol><li><h1><h2><h3><h4><h5><h6><sub><strike><details><figure><figcaption><mark><menu><meter><nav><output><ruby><rt><rp><section><details><summary><time><wbr>'); 
//'<div><p><br><hr><a><b><q><i><s><img><span><ui><ol><li><h1><h2><h3><h4><h5><h6><sub><strike><details><figure><figcaption><mark><menu><meter><nav><output><ruby><rt><rp><section><details><summary><time><wbr>'
        }

        return $this->userDetail;
    }

    public function parceSocUrl($socNet, $url)
    {
        $username = $url;
        if ($socNet == 'Last.fm')
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

    public function contentNeedSave($link)
    {
        $answer = false;
        $net = $this->getNetByLink($link);

        if (isset($net['contentClass']) && strlen($net['contentClass']))
        {
            $class = $net['contentClass'];
            $answer = $class::contentNeedSave($link);
        }
        
        return $answer;
    }

    public function followSocial($netName, $param)
    {
        $answer = false;
        $net = $this->getNetByName($netName);

        if (isset($net['contentClass']) && strlen($net['contentClass']) /*&& $this->isLoggegOn($netName, false)*/)
        {
            $class = $net['contentClass'];
            $answer = $class::followSocial($param);
        }
        
        return $answer;
    }
    
    public function mergeMobile($netName)
    {
        if (strpos($netName, '_mobile') !== false)
            $netName = substr($netName, 0, (strpos($netName, '_mobile')));
        return $netName;
    }
    
    public static function getNameBySharingType($sharing_type)
    {
        $answer = '';
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net)
        {
            if (in_array($sharing_type, $net['sharingType']))
            {
                $answer = $net['name'];
                break;
            }
        }
        return $answer;
    }
    
    public static function getTokenBySharingType($sharing_type)
    {
        $answer = '';
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net)
        {
            if (in_array($sharing_type, $net['sharingType']))
            {
                $answer = $net['tokenType'];
                break;
            }
        }
        return $answer;
    }
}