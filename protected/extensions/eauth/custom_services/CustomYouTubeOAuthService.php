<?php

require_once dirname(dirname(__FILE__)) . '/EOAuth2Service.php';

class CustomYouTubeOAuthService extends EOAuth2Service
{

    protected $name = 'youtube';
    protected $title = 'YouTube';
    protected $type = 'OAuth';
    protected $jsArguments = array('popup' => array('width' => 500, 'height' => 450));
    protected $client_id = '';
    protected $client_secret = '';
    protected $key = '';
    protected $scope = 'https://www.googleapis.com/auth/youtube';
    protected $providerOptions = array(
        'authorize' => 'https://accounts.google.com/o/oauth2/auth',
        'access_token' => 'https://accounts.google.com/o/oauth2/token',
    );

    protected function fetchAttributes()
    {
//        $userProfileEntry = $this->makeSignedRequest('http://gdata.youtube.com/feeds/api/users/default');
        Yii::import('ext.ZendGdata.library.*');
        require_once('Zend/Gdata/YouTube.php');
        require_once('Zend/Gdata/AuthSub.php');

        $httpClient = Zend_Gdata_AuthSub::getHttpClient($this->getState('auth_token'));
        $httpClient->setHeaders('X-GData-Key', 'key=' . $this->key);

        $yt = new Zend_Gdata_YouTube($httpClient);
        $yt->setMajorProtocolVersion(2);
        $userProfileEntry = $yt->getUserProfile('default');

        $this->attributes['id'] = (string) $userProfileEntry->getUsername();
        $this->attributes['photo'] = (string) $userProfileEntry->getThumbnail()->getUrl();
        $this->attributes['url'] = (string) 'http://www.youtube.com/channel/UC' . $this->attributes['id'];
        $this->attributes['name'] = (string) $userProfileEntry->title->text;
        $this->attributes['age'] = (string) $userProfileEntry->getAge();
        $this->attributes['gender'] = (string) $userProfileEntry->getGender();
        $this->attributes['location'] = (string) $userProfileEntry->getLocation();
        $this->attributes['school'] = (string) $userProfileEntry->getSchool();
        $this->attributes['work'] = (string) $userProfileEntry->getCompany();
        $this->attributes['about'] = (string) $userProfileEntry->getOccupation();
        $videoFeed = $yt->getuserUploads('default');
        if (isset($videoFeed[0]))
        {
            $videoEntry = $videoFeed[0];
            $this->attributes['utube_video_link'] = '<a href="' . (string) $videoEntry->getVideoWatchPageUrl() . '" target="_blank">' . (string) $videoEntry->getVideoTitle() . '</a>';
            $this->attributes['utube_video_flash'] = (string) $videoEntry->getFlashPlayerUrl();
        }

        if (!Yii::app()->user->isGuest)
        {
            $socToken = SocToken::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'type' => SocToken::TYPE_YOUTUBE,
            ));

            if ($socToken)
            {
                $socToken->soc_id = (string) $userProfileEntry->getUsername();
                $socToken->soc_username = (string) $userProfileEntry->title->text;
                $socToken->save();
            }
        }
    }

    protected function getCodeUrl($redirect_uri)
    {
        $this->setState('redirect_uri', $redirect_uri);
        $url = parent::getCodeUrl($redirect_uri);
        if (isset($_GET['js']))
            $url .= '&display=popup';

        $url .= '&access_type=offline';

        if (!Yii::app()->user->isGuest)
        {
            $socToken = SocToken::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'type' => SocToken::TYPE_YOUTUBE,
            ));

            if (!$socToken or !$socToken->refresh_token)
            {
                $url .= '&approval_prompt=force';
            }
        }
        else
            $url .= '&approval_prompt=force';

        return $url;
    }

    protected function getTokenUrl($code)
    {
        return $this->providerOptions['access_token'];
    }

    protected function getAccessToken($code)
    {
        $params = array(
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $this->getState('redirect_uri'),
        );
        return $this->makeRequest($this->getTokenUrl($code), array('data' => $params));
    }

    /**
     * Save access token to the session.
     * @param stdClass $token access token array.
     */
    protected function saveAccessToken($token)
    {
        if (!Yii::app()->user->isGuest)
        {
            $socToken = SocToken::model()->findByAttributes(array(
                'user_id' => Yii::app()->user->id,
                'type' => SocToken::TYPE_YOUTUBE,
            ));

            if (!$socToken)
                $socToken = new SocToken;
            $socToken->type = SocToken::TYPE_YOUTUBE;
            $socToken->user_id = Yii::app()->user->id;
            $socToken->user_token = $token->access_token;
            if (!empty($token->refresh_token))
                $socToken->refresh_token = $token->refresh_token;
            $socToken->token_expires = time() + $token->expires_in - 60;

            $socToken->save();
        }

        $this->setState('auth_token', $token->access_token);
        $this->setState('expires', time() + $token->expires_in - 60);
        $this->access_token = $token->access_token;
        parent::saveAccessToken($token);
    }

    /**
     * Makes the curl request to the url.
     * @param string $url url to request.
     * @param array $options HTTP request options. Keys: query, data, referer.
     * @param boolean $parseJson Whether to parse response in json format.
     * @return string the response.
     */
    protected function makeRequest($url, $options = array(), $parseJson = true)
    {
        $options['query']['alt'] = 'json';
        return parent::makeRequest($url, $options, $parseJson);
    }

    /**
     * Returns the error info from json.
     * @param stdClass $json the json response.
     * @return array the error array with 2 keys: code and message. Should be null if no errors.
     */
    protected function fetchJsonError($json)
    {
        if (isset($json->error))
        {
            return array(
                'code' => $json->error->code,
                'message' => $json->error->message,
            );
        }
        else
            return null;
    }

}
