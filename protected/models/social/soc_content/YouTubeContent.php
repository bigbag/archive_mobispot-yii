<?php

class YouTubeContent extends SocContentBase
{

    const API_PATH = 'https://www.googleapis.com/youtube/';
    const TOKEN_URL = 'https://accounts.google.com/o/oauth2/token';

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = $link;
        $result = 'ok';
/*
        $username = '';
        if (strpos($socUsername, 'youtube.com/channel/') !== false)
            $username = substr($socUsername, (strpos($socUsername, 'youtube.com/channel/') + 20));
        if (strpos($socUsername, 'youtube.com/user/') !== false)
            $username = substr($socUsername, (strpos($socUsername, 'youtube.com/user/') + 17));
        if (strlen($username) > 0) {
            $username = self::rmGetParam($username);

            Yii::import('ext.ZendGdata.library.*');
            require_once('Zend/Gdata/YouTube.php');
            require_once('Zend/Gdata/AuthSub.php');

            $yt = new Zend_Gdata_YouTube();
            $yt->setMajorProtocolVersion(2);
            try {
                $userProfileEntry = $yt->getUserProfile($username);
                $result = 'ok';
            } catch (Exception $e) {
                $result = Yii::t('social', "This account doesn't exist:") . $socUsername;
            }
        } else {
            $videoId = '';
            if ((strpos($socUsername, 'youtube.com') !== false) && (strpos($socUsername, 'watch?v=') !== false)) {
                $videoId = self::rmGetParam(substr($socUsername, (strpos($socUsername, 'watch?v=') + 8)));

                Yii::import('ext.ZendGdata.library.*');
                require_once('Zend/Gdata/YouTube.php');
                require_once('Zend/Gdata/AuthSub.php');

                $yt = new Zend_Gdata_YouTube();
                $yt->setMajorProtocolVersion(2);
                try {
                    $videoEntry = $yt->getVideoEntry($videoId);
                    $result = 'ok';
                } catch (Exception $e) {
                    $result = Yii::t('social', "This post doesn't exist:") . $videoId;
                }
            }
        }
*/

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $userDetail['block_type'] = self::YOUTUBE_VIDEO;

        //$userXML = $self::makeRequest('http://gdata.youtube.com/feeds/api/users/'.$socUsername);
        $username = '';
        $chanel_id = '';
        $video_id = self::videoIdFromUrl($link);
        
        $userDetail['soc_username'] = Yii::t('social', "This account doesn't exist:") . $link;
        $userDetail['error'] = $userDetail['soc_username'];
        
        if ($video_id) {
            //привязано видео
            $video_entries = self::makeRequest(
                'https://www.googleapis.com/youtube/v3/'
                . 'videos?part=id%2Csnippet%2Cplayer%2Cstatistics'
                . '&id=' . $video_id 
                . '&key=' . Yii::app()->eauth->services['youtube']['key']);
                
            if (empty($video_entries['items']) 
                or empty($video_entries['items'][0]) 
                or empty($video_entries['items'][0]['snippet'])
                or empty($video_entries['items'][0]['player'])
                or empty($video_entries['items'][0]['player']['embedHtml'])
                )
                return $userDetail;
                
            $video_entry = $video_entries['items'][0];
            
            unset($userDetail['error']);
            $userDetail['soc_username'] = 
                empty($video_entry['snippet']['channelTitle'])
                ?''
                :$video_entry['snippet']['channelTitle'];
                
            $userDetail['embedHtml'] = $video_entry['player']['embedHtml'];
            
            if (!empty($video_entry['statistics']) and !empty($video_entry['statistics']['viewCount']))
                $userDetail['view_count'] = $video_entry['statistics']['viewCount'];
            
            $video_embed = self::makeRequest(
            'http://www.youtube.com/oembed?url=' 
            . urlencode($link) 
            . '&format=json');
            
            if (!empty($video_embed['author_name'])) {
                $userDetail['soc_username'] = $video_embed['author_name'];
            }
            
            if (!empty($video_embed['author_url'])) {

                $username = self::parseParam($video_embed['author_url'], '/user/');

                $user_url = 'http://gdata.youtube.com/feeds/api/users/'
                    . $username 
                    . '?fields=yt:username,media:thumbnail,title&alt=json-in-script&format=5&callback=showYouTubeProfileInfo';
                $user = self::makeRequest($user_url, array(), false);
                
                $photo = self::parseParam($user, '"media$thumbnail":{"url":"');
                if ($photo and strpos($photo, '"') > 0)
                    $photo = substr($photo, 0, strpos($photo, '"'));
                
                if ($photo)
                    $userDetail['photo'] = $photo;
            }
        }
        elseif ((strpos($link, '/user/') > 0)){
            //привязан пользователь
            $username = self::parseParam($link, '/user/');        
            
            $chanels_url = 
                'https://www.googleapis.com/youtube/v3/channels'
                . '?part=brandingSettings,contentDetails'
                . '&forUsername=' . $username 
                . '&key=' . Yii::app()->eauth->services['youtube']['key'];
                
            $chanels = self::makeRequest($chanels_url);
            
            if (empty($chanels['items']) 
                or empty($chanels['items'][0])
                or empty($chanels['items'][0]['id']))
                return $userDetail;
                
            $chanel = $chanels['items'][0];
                
            $search_url = 
                'https://www.googleapis.com/youtube/v3/search'
                . '?part=id,snippet'
                . '&channelId=' . $chanel['id'] 
                . '&order=date&type=video&videoSyndicated=true&maxResults=1'
                . '&key=' . Yii::app()->eauth->services['youtube']['key'];
                
            $video_entries = self::makeRequest($search_url);
            
            if (empty($video_entries['items']) 
                or empty($video_entries['items'][0])
                or empty($video_entries['items'][0]['id'])
                or empty($video_entries['items'][0]['id']['videoId']))
                return $userDetail;
                
            $video_id = $video_entries['items'][0]['id']['videoId'];
            
            $video_entries = self::makeRequest(
                'https://www.googleapis.com/youtube/v3/'
                . 'videos?part=id%2Csnippet%2Cplayer%2Cstatistics'
                . '&id=' . $video_id 
                . '&key=' . Yii::app()->eauth->services['youtube']['key']);
                
            if (empty($video_entries['items']) 
                or empty($video_entries['items'][0]) 
                or empty($video_entries['items'][0]['snippet'])
                or empty($video_entries['items'][0]['player'])
                or empty($video_entries['items'][0]['player']['embedHtml'])
                )
                return $userDetail;
                
            $video_entry = $video_entries['items'][0];
            
            unset($userDetail['error']);
            $userDetail['soc_username'] = 
                empty($video_entry['snippet']['channelTitle'])
                ?''
                :$video_entry['snippet']['channelTitle'];
                
            $userDetail['embedHtml'] = $video_entry['player']['embedHtml'];
            
            if (!empty($video_entry['statistics']) and !empty($video_entry['statistics']['viewCount']))
                $userDetail['view_count'] = $video_entry['statistics']['viewCount'];
////////////////////            
        }
        elseif ((strpos($link, '/channel/') > 0)) {
            //канал
            $chanel_id = self::parseParam($link, '/channel/');
            
            $search_url = 
                'https://www.googleapis.com/youtube/v3/search'
                . '?part=id,snippet'
                . '&channelId=' . $chanel_id
                . '&order=date&type=video&videoSyndicated=true&maxResults=1'
                . '&key=' . Yii::app()->eauth->services['youtube']['key'];
                
            $video_entries = self::makeRequest($search_url);
            
            if (empty($video_entries['items']) 
                or empty($video_entries['items'][0])
                or empty($video_entries['items'][0]['id'])
                or empty($video_entries['items'][0]['id']['videoId']))
                return $userDetail;
                
            $video_id = $video_entries['items'][0]['id']['videoId'];
            
            $video_entries = self::makeRequest(
                'https://www.googleapis.com/youtube/v3/'
                . 'videos?part=id%2Csnippet%2Cplayer%2Cstatistics'
                . '&id=' . $video_id 
                . '&key=' . Yii::app()->eauth->services['youtube']['key']);
                
            if (empty($video_entries['items']) 
                or empty($video_entries['items'][0]) 
                or empty($video_entries['items'][0]['snippet'])
                or empty($video_entries['items'][0]['player'])
                or empty($video_entries['items'][0]['player']['embedHtml'])
                )
                return $userDetail;
                
            $video_entry = $video_entries['items'][0];
            
            unset($userDetail['error']);
            $userDetail['soc_username'] = 
                empty($video_entry['snippet']['channelTitle'])
                ?''
                :$video_entry['snippet']['channelTitle'];
                
            $userDetail['embedHtml'] = $video_entry['player']['embedHtml'];
            
            if (!empty($video_entry['statistics']) and !empty($video_entry['statistics']['viewCount']))
                $userDetail['view_count'] = $video_entry['statistics']['viewCount'];            
        }
        
        $userDetail['avatar_before_mess_body'] = true;
        
        return $userDetail;
    }

    
    
    public static function parseUsername($link)
    {
        return $link;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['YouTube_id']))
            $answer = true;

        return $answer;
    }

    public static function checkSharing($loyalty)
    {
        $answer = false;

        $link = $loyalty->getLink();
        if (empty($link))
            return false;

        switch($loyalty->sharing_type) {
            case Loyalty::YOUTUBE_FOLLOWING:
                $data = CJSON::decode($loyalty->data);
                if (!empty($data['channelId']))
                    $answer = self::checkFollowing($data['channelId']);
            break;
            case Loyalty::YOUTUBE_VIEWS:
                $answer = self::checkView($link);
            break;
        }

        return $answer;
    }

    public static function checkFollowing($channel_id)
    {
        $answer = false;


        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocToken::TYPE_YOUTUBE,
        ));

        if (!$socToken)
            return false;

        $options = array(
            'headers'=>array(
            'Authorization:Bearer '
            . $socToken->user_token));

        $subscriptions = self::makeRequest(
            self::API_PATH
            .'v3/subscriptions?maxResults=50&part=snippet&mine=true'
        );


        return $answer;
    }

    public static function checkView($link)
    {
        $answer = false;

        return $answer;
    }

    public static function refreshToken($token)
    {
        $answer = false;

        if (empty($token->refresh_token) or (time() + 60 < $token->token_expires))
            return false;

        $options = array('data' =>
            'client_id='
            . Yii::app()->eauth->services['youtube']['client_id']
            . '&client_secret='
            . Yii::app()->eauth->services['youtube']['client_secret']
            . '&refresh_token='
            . $token->refresh_token
            .'&grant_type=refresh_token'
        );

        $newToken = self::makeRequest(self::TOKEN_URL, $options, true);

        if (!empty($newToken['access_token']) and !empty($newToken['expires_in'])) {
            $token->user_token = $newToken['access_token'];
            $token->token_expires = time() + $newToken['expires_in'] - 60;
            $token->save();
            $answer = true;
        }

        return $answer;
    }
    
    /**
     * get youtube video ID from URL
     *
     * @param string $url
     * @return string Youtube video id or FALSE if none found. 
     */
    public static function videoIdFromUrl($url) {
        $pattern = 
            '%^# Match any youtube URL
            (?:https?://)?  # Optional scheme. Either http or https
            (?:www\.)?      # Optional www subdomain
            (?:             # Group host alternatives
              youtu\.be/    # Either youtu.be,
            | youtube\.com  # or youtube.com
              (?:           # Group path alternatives
                /embed/     # Either /embed/
              | /v/         # or /v/
              | /watch\?v=  # or /watch\?v=
              | /ytscreeningroom?v=
              )             # End path alternatives.
            )               # End host alternatives.
            ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
            $%x'
            ;
        $result = preg_match($pattern, $url, $matches);
        if (false !== $result and !empty($matches[1])) {
            return $matches[1];
        } elseif ($url != self::rmGetParam($url)) {
            return self::videoIdFromUrl(self::rmGetParam($url));
        }
        return false;
    }

}
