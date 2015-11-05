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
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc_g';
        $net['inviteValue'] = ''; //'&#xe009;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Google от Mobispot?');
        $net['smallIcon'] = 'google.png';
        $net['contentClass'] = 'GoogleContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $net['sharingType'] = array(Loyalty::GOOGLE_CIRCLE, Loyalty::GOOGLE_PLUS_ONE);
        $net['tokenType'] = SocToken::TYPE_GOOGLE;
        $socNetworks[] = $net;

        $net['name'] = 'facebook';
        $net['baseUrl'] = 'facebook.com';
        $net['title'] = 'Facebook';
        $net['invite'] = Yii::t('social', 'Make friends');
        $net['inviteClass'] = ''; //'i-soc-fac';
        $net['inviteValue'] = ''; //'&#xe008;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Facebook от Mobispot?');
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
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc_twi';
        $net['inviteValue'] = ''; //'&#xe007';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Twitter от Mobispot?');
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
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc_vk';
        $net['inviteValue'] = ''; //'&#xe002;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт ВКонтакте от Mobispot?');
        $net['smallIcon'] = 'vk.png';
        $net['contentClass'] = 'VkContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $net['sharingType'] = array(Loyalty::VK_SUBS, Loyalty::VK_LIKE);
        $net['tokenType'] = SocToken::TYPE_VK;
        $socNetworks[] = $net;

        $net['name'] = 'linkedin';
        $net['baseUrl'] = 'linkedin.com';
        $net['title'] = 'LinkedIn';
        $net['invite'] = Yii::t('social', 'Connect me');
        $net['inviteClass'] = ''; //'i-soc_in';
        $net['inviteValue'] = ''; //'&#xe005;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт LinkedIn от Mobispot?');
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
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc-fo';
        $net['inviteValue'] = ''; //'&#xe00a;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Foursquare от Mobispot?');
        $net['smallIcon'] = 'foursquare.png';
        $net['contentClass'] = 'FoursquareContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $net['sharingType'] = array(Loyalty::FOURSQUARE_CHECKIN, Loyalty::FOURSQUARE_MAYOR, Loyalty::FOURSQUARE_BADGE);
        $net['tokenType'] = SocToken::TYPE_FOURSQUARE;
        $socNetworks[] = $net;

        $net['name'] = 'vimeo';
        $net['baseUrl'] = 'vimeo.com';
        $net['title'] = 'Vimeo';
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc_vo';
        $net['inviteValue'] = ''; //'&#xe003;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Vimeo от Mobispot?');
        $net['smallIcon'] = 'vimeo.png';
        $net['contentClass'] = 'VimeoContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_VIMEO;
        $socNetworks[] = $net;

        $net['name'] = 'deviantart';
        $net['baseUrl'] = 'deviantart.com';
        $net['title'] = 'DeviantART';
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc-da';
        $net['inviteValue'] = ''; //'&#xe00b;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт DeviantART от Mobispot?');
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
        $net['invite'] = Yii::t('social', 'See more');
        $net['inviteClass'] = ''; //'i-soc-be';
        $net['inviteValue'] = ''; //'&#xe00c;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Behance от Mobispot?');
        $net['smallIcon'] = 'behance.png';
        $net['contentClass'] = 'BehanceContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('social', 'Please paste the link to your Behance profile here');
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_BEHANCE;
        $socNetworks[] = $net;

        $net['name'] = 'YouTube';
        $net['baseUrl'] = 'youtube.com';
        $net['title'] = 'YouTube';
        $net['invite'] = Yii::t('social', 'Watch more');
        $net['inviteClass'] = ''; //'i-soc_yt';
        $net['inviteValue'] = ''; //'&#xe000;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт YouTube от Mobispot?');
        $net['smallIcon'] = 'youtube.png';
        $net['contentClass'] = 'YouTubeContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('social', 'Please paste the link to your YouTube profile here');
        $net['sharingType'] = array(Loyalty::YOUTUBE_FOLLOWING, Loyalty::YOUTUBE_VIEWS);
        $net['tokenType'] = SocToken::TYPE_YOUTUBE;
        $socNetworks[] = $net;

        $net['name'] = 'instagram';
        $net['baseUrl'] = 'instagram.com';
        $net['title'] = 'Instagram';
        $net['invite'] = Yii::t('social', 'Follow me');
        $net['inviteClass'] = ''; //'i-soc_ing';
        $net['inviteValue'] = ''; //'&#xe006;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт Instagram от Mobispot?');
        $net['smallIcon'] = 'instagram.png';
        $net['contentClass'] = 'InstagramContent';
        $net['needAuth'] = true;
        $net['profileHint'] = '';
        $net['sharingType'] = array(Loyalty::INSTAGRAM_LIKE, Loyalty::INSTAGRAM_FOLLOWING);
        $net['tokenType'] = SocToken::TYPE_INSTAGRAM;
        $socNetworks[] = $net;

        $net['name'] = 'pinterest';
        $net['baseUrl'] = 'pinterest.com';
        $net['title'] = 'Pinterest';
        $net['invite'] = Yii::t('social', 'See more pins');
        $net['inviteClass'] = ''; //'i-soc-pin';
        $net['inviteValue'] = ''; //'&#xe017;';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', '');
        $net['smallIcon'] = 'pinterest.png';
        $net['contentClass'] = 'PinterestContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('social', 'Please paste the link to your Pinterest profile here');
        $net['sharingType'] = array();
        $net['tokenType'] = null;
        $socNetworks[] = $net;

        $net['name'] = 'crunchbase';
        $net['baseUrl'] = 'crunchbase.com';
        $net['title'] = 'CrunchBase';
        $net['invite'] = Yii::t('social', 'Watch more');
        $net['inviteClass'] = '';
        $net['inviteValue'] = '';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', '');
        $net['smallIcon'] = 'crunchbase.png';
        $net['contentClass'] = 'CrunchBaseContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('social', 'Please paste the link to your Crunchbase profile here');
        $net['sharingType'] = array();
        $net['tokenType'] = null;
        $socNetworks[] = $net;

        $net['name'] = 'tumblr';
        $net['baseUrl'] = 'tumblr.com';
        $net['title'] = 'tumblr';
        $net['invite'] = Yii::t('social', 'Follow me'); //'Read more');
        $net['inviteClass'] = '';
        $net['inviteValue'] = '';
        $net['note'] = Yii::t('social', '');
        $net['unbind_warning'] = Yii::t('social', 'Отсоединить Ваш аккаунт tumblr от Mobispot?');
        $net['smallIcon'] = 'tumblr.png';
        $net['contentClass'] = 'TumblrContent';
        $net['needAuth'] = false;
        $net['profileHint'] = Yii::t('social', 'Please paste the link to your tumblr profile here');
        $socNetworks[] = $net;
        $net['sharingType'] = array();
        $net['tokenType'] = SocToken::TYPE_TUMBLR;
        return $socNetworks;
    }

    public function getNetData($link, $discodesId = null, $dataKey = null, $dinamic = false)
    {
        $this->socNet = '';
        $this->socUsername = '';
        $this->userDetail = array();
        $net = $this->getNetByLink($link);

        if (!empty($net['name'])) {
            $this->socNet = $net['name'];
            $this->socUsername = $this->parceSocUrl($this->socNet, $link);
            $this->getSocInfo($this->socNet, $this->socUsername, $discodesId, $dataKey);
            if (empty($this->userDetail['invite']))
                $this->userDetail['invite'] = $net['invite'];
            $this->userDetail['inviteClass'] = $net['inviteClass'];
            $this->userDetail['inviteValue'] = $net['inviteValue'];
            $this->userDetail['netName'] = $this->socNet;
        }

        if ($dinamic)
            $this->userDetail['dinamic'] = true;

        if (empty($this->userDetail['soc_url']))
            $this->userDetail['soc_url'] = $link;

        return $this->userDetail;
    }

    public function getNetByName($name)
    {
        $answer = false;
        
        $name = $this->mergeMobile($name);
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net) {
            if ($name == $net['name']) {
                $answer = $net;
                break;
            }
        }
        return $answer;
    }
    
    public function getNetByType($type)
    {
        $answer = false;
        
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net) {
            if ($type == $net['tokenType']) {
                $answer = $net;
                break;
            }
        }
        return $answer;
    }

    public function getNetByLink($link)
    {
        $answer = array();
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net) {
            if (strpos($link, $net['baseUrl']) !== false) {
                $answer = $net;
                break;
            }
        }

        if (empty($answer['name']) and (strpos($link, '.') !== false)) {
            $tumblrLink = TumblrContent::parseUsername($link);
            if (!empty(Yii::app()->eauth->services['tumblr'])) {
                $blogInfo = TumblrContent::makeRequest('http://api.tumblr.com/v2/blog/' . $tumblrLink . '/info?api_key=' . Yii::app()->eauth->services['tumblr']['key']);
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
        if (isset($net['contentClass']) && strlen($net['contentClass'])) {
            $class = $net['contentClass'];
            $answer = $class::isLinkCorrect($link, $discodesId, $dataKey);
        }

        return $answer;
    }

    public function getSocPatterns()
    {
        $answer = array();
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net) {

            if (!empty($net['baseUrl'])) {
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
        if ($checkNeed and $net['needAuth'] == false) {
            $answer = true;
        } elseif (isset($net['contentClass']) && strlen($net['contentClass'])) {
            $class = $net['contentClass'];
            $answer = $class::isLoggegByNet();
        } elseif (!empty(Yii::app()->session[$net['name'] . '_id']))
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

        if ($cachedData !== false) {
            $this->userDetail = $cachedData;
            return $this->userDetail;
        }

        $this->userDetail['service'] = $socNet;
        $this->userDetail['UserExists'] = false;
        $socUsername = $this->parceSocUrl($socNet, $socUsername);

        $net = $this->getNetByLink($socUsername);
        if (isset($net['contentClass']) && strlen($net['contentClass'])) {
            $class = $net['contentClass'];
            $this->userDetail = $class::getContent($socUsername, $discodesId, $dataKey);
        } else
            $this->userDetail['soc_username'] = Yii::t('social', 'This social network is not supported by Mobispot: ') . $socNet;

        Yii::app()->cache->set('socData_' . md5($socUsername), $this->userDetail, 120);

        $uncheck = array('html', 'list', 'list2', 'follow_button', 'embedHtml');

        if (empty($this->userDetail['binded_link'])) {
            $this->userDetail['binded_link'] = $socUsername;
        }

        foreach ($this->userDetail as $socKey => $socValue) {
            if (!is_array($socValue) && !in_array($socKey, $uncheck))
                $this->userDetail[$socKey] = strip_tags((string) $socValue, '<div><p><br><hr><a><b><q><i><s><img><span><ui><ol><li><h1><h2><h3><h4><h5><h6><sub><strike><details><figure><figcaption><mark><menu><meter><nav><output><ruby><rt><rp><section><details><summary><time><wbr>');
        }

        return $this->userDetail;
    }

    public function parceSocUrl($socNet, $url)
    {
        $username = $url;
        if ($socNet == 'Last.fm') {
            if ((strpos($username, 'lastfm.ru/user/') > 0) || (strpos($username, 'lastfm.ru/user/') !== false))
                $username = substr($username, (strpos($username, 'lastfm.ru/user/') + 15));
            if (strpos($username, '?') > 0)
                $username = substr($username, 0, strpos($username, '?'));
            if (strpos($username, '/') > 0)
                $username = substr($username, 0, strpos($username, '/'));
            if (strpos($username, '&') > 0)
                $username = substr($username, 0, strpos($username, '&'));
        } elseif ($socNet == 'Flickr') {
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

    public function js_urlencode($str)
    {
        $str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
        $out = '';
        for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++) {
            $out .= '%u' . bin2hex(mb_substr($str, $i, 1, 'UTF-16'));
        }

        return $out;
    }

    public function contentNeedSave($link)
    {
        $answer = false;
        $net = $this->getNetByLink($link);

        if (isset($net['contentClass']) and strlen($net['contentClass'])) {
            $class = $net['contentClass'];
            $answer = $class::contentNeedSave($link);
        }

        return $answer;
    }

    public function followSocial($netName, $param)
    {
        $answer = false;
        $net = $this->getNetByName($netName);

        if (isset($net['contentClass']) && strlen($net['contentClass']) /* && $this->isLoggegOn($netName, false) */) {
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
        foreach ($socNetworks as $net) {
            if (in_array($sharing_type, $net['sharingType'])) {
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
        foreach ($socNetworks as $net) {
            if (in_array($sharing_type, $net['sharingType'])) {
                $answer = $net['tokenType'];
                break;
            }
        }
        return $answer;
    }

    public static function getNetByTokenType($token_type)
    {
        $answer = array();
        $socNetworks = self::getSocNetworks();
        foreach ($socNetworks as $net) {
            if ($net['tokenType'] == $token_type) {
                $answer = $net;
                break;
            }
        }
        return $answer;
    }

    public static function checkToken($token_type, $user_token, $token_secret = '')
    {
        $answer = null;
        $net = self::getNetByTokenType($token_type);
        $class = $net['contentClass'];
        $answer = $class::checkToken($user_token, $token_secret);

        return $answer;
    }

    public static function setLogged($atributes)
    {
        $success = false;
        if (!empty($atributes['service']) and !empty($atributes['id'])) {
            Yii::app()->session[$atributes['service'] . '_id'] = $atributes['id'];
            if (!empty($atributes['url']))
                Yii::app()->session[$atributes['service'] . '_profile_url'] = $atributes['url'];
            $success = true;
        }

        return $success;
    }
    
    public static function setGuest($net_name)
    {
        if (empty(Yii::app()->session[$net_name . '_id']) 
            and empty(Yii::app()->session[$net_name . '_profile_url']))
            return false;
            
        if (!empty(Yii::app()->session[$net_name . '_id']))
            unset(Yii::app()->session[$net_name . '_id']);
        
        if (!empty(Yii::app()->session[$net_name . '_profile_url']))
            unset(Yii::app()->session[$net_name . '_profile_url']);
        
        return true;
    }

    public static function showFileSize($file)
    {
        if(!file_exists($file)) return '';

        $filesize = filesize($file);

        if($filesize > 1024) {
            $filesize = ($filesize/1024);

            if($filesize > 1024) {
                $filesize = ($filesize/1024);

                if($filesize > 1024) {
                    $filesize = ($filesize/1024);
                    $filesize = round($filesize, 1);
                    return $filesize.' '.Yii::t('spot', 'GB');
                } else {
                    $filesize = round($filesize, 1);
                    return $filesize.' '.Yii::t('spot', 'MB');
                }
            } else {
                $filesize = round($filesize, 1);
                return $filesize.' '.Yii::t('spot', 'Kb');
            }
        } else {
            $filesize = round($filesize, 1);
            return $filesize.' '.Yii::t('spot', 'bytes');
        }
    }

    public function checkSharing($loyalty)
    {
        $answer = false;

        if (empty($loyalty->sharing_type))
            return false;

        $net = $this->getNetByName(
            self::getNameBySharingType($loyalty->sharing_type));

        if (!empty($net['contentClass'])) {
            $class = $net['contentClass'];
            $answer = $class::checkSharing($loyalty);
        }

        return $answer;
    }

    public function checkLoyaltySharing($loyaltySharing)
    {
        $answer = false;

        if (empty($loyaltySharing->sharing_type))
            return false;

        $net = $this->getNetByName(
            self::getNameBySharingType($loyaltySharing->sharing_type));

        if (!empty($net['contentClass'])) {
            $class = $net['contentClass'];
            $answer = $class::checkSharing($loyaltySharing);
        }

        return $answer;
    }

    public static function nameInList($name, $list)
    {
        $answer = false;
        foreach($list as $item) {
            if (!empty($item['name']) and $item['name'] == $name)
                $answer = true;
        }

        return $answer;
    }

    public function linkInList($link, $list)
    {
        $answer = false;

        $net = $this->getNetByLink($link);
        if (!$net)
            return false;

        $answer = self::nameInList($name, $list);

        return $answer;
    }
    
    public function getBindedLink($link, $netName, $discodes_id, $key)
    {
        $net = $this->getNetByName($netName);

        $class = $net['contentClass'];
        $answer = $class::getBindedLink($link, $discodes_id, $key);

        return $answer;
    }
    
    public function getUnbindWarning($net_name)
    {
        $net = $this->getNetByName($net_name);
        if (empty($net) or empty($net['unbind_warning']))
            return '';
        
        return $net['unbind_warning'];
    }

    public static function writeAccessBySocInfo($info)
    {
    //заготовка пока нет необходимости делать логику
        $answer = false;
        if ('facebook' == $info['service'])
            $answer = true;

        return $answer;
    }

}




/*
контент неиспользуемых соцсетей
        elseif ($socNet == 'Last.fm') {
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
        } elseif ($socNet == 'Flickr') {
            //if not id
            if (strpos($socUsername, '@') === false) {
                $socUsername = str_replace(' ', '+', $socUsername);
                $socUser = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.findByUsername&api_key=dc1985d59dc4b427afefe54c912fae0a&username=' . $socUsername . '&format=json&nojsoncallback=1');
                //replace username by id
                if ($socUser['stat'] == 'ok')
                    $socUsername = $socUser['user']['id'];
            }

            $socUser = $this->makeRequest('http://api.flickr.com/services/rest/?method=flickr.people.getInfo&api_key=dc1985d59dc4b427afefe54c912fae0a&user_id=' . urlencode($socUsername) . '&format=json&nojsoncallback=1');
            if ($socUser['stat'] == 'ok') {
                $socUser = $socUser['person'];
                if (!empty($socUser['realname']['_content']))
                    $this->userDetail['soc_username'] = $socUser['realname']['_content'];
                else
                    $this->userDetail['soc_username'] = $socUser['username']['_content'];
                if (!empty($socUser['iconserver'])) {
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
                if (($photo['stat'] == 'ok') && !empty($photo['photos']['photo'][0]['id'])) {
                    $photo = $photo['photos']['photo'][0];
                    $this->userDetail['last_photo'] = '<img src="http://farm' . $photo['farm'] . '.staticflickr.com/' . $photo['server'] . '/' . $photo['id'] . '_' . $photo['secret'] . '_z.jpg"/><br/>' . $photo['title'];
                }
            } else
                $this->userDetail['soc_username'] = Yii::t('social', "This account doesn't exist:") . $socUsername;
        }
*/
