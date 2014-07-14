<?php

class TwitterContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';

        $appToken = false;
        if ($appToken === false) {
            $credentials = base64_encode(urlencode(Yii::app()->eauth->services['twitter']['key']) . ':' . urlencode(Yii::app()->eauth->services['twitter']['secret']));
            $url = 'https://api.twitter.com/oauth2/token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic ' . $credentials,
                'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
            ));
            $curl_result = curl_exec($ch);
            $curl_error = curl_error($ch);
            if ($curl_error)
                Yii::log($curl_error, 'error', 'application');

            curl_close($ch);
            $curl_result = CJSON::decode($curl_result, true);
            if (!empty($curl_result['access_token']))
                $appToken = $curl_result['access_token'];
        }

        if (!(strpos($link, 'twitter.com/') !== false) or !(strpos($link, '/status/') !== false)) {
            //профиль
            $socUsername = self::parseUsername($link);
            $url = 'https://api.twitter.com/1.1/users/show.json';
            if (is_numeric($socUsername))
                $url .= '?user_id=' . $socUsername;
            else
                $url .= '?screen_name=' . $socUsername;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $appToken
            ));
            $curl_result = curl_exec($ch);
            $curl_error = curl_error($ch);
            if ($curl_error)
                Yii::log($curl_error, 'error', 'application');

            curl_close($ch);

            $socUser = CJSON::decode($curl_result, true);
            if (!empty($socUser['error']) || empty($socUser['id'])) {
                $result = Yii::t('social', "This account doesn't exist:") . $socUsername;
            }
        }

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();

        //$appToken = Yii::app()->cache->get('twitterAppToken');
        $appToken = false;
        if ($appToken === false) {
            $credentials = base64_encode(urlencode(Yii::app()->eauth->services['twitter']['key']) . ':' . urlencode(Yii::app()->eauth->services['twitter']['secret']));
            $url = 'https://api.twitter.com/oauth2/token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic ' . $credentials,
                'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'
            ));
            $curl_result = curl_exec($ch);
            curl_close($ch);
            $curl_result = CJSON::decode($curl_result, true);
            if (!empty($curl_result['access_token']))
                $appToken = $curl_result['access_token'];
            //Yii::app()->cache->set('twitterAppToken', $appToken);
        }

        $userDetail['block_type'] = self::TYPE_TWEET;

        if ((strpos($link, 'twitter.com/') !== false) && (strpos($link, '/status/') !== false)) {
            //твитт
            $tweetId = substr($link, (strpos($link, '/status/') + 8));
            $tweetId = self::rmGetParam($tweetId);

            $url = 'https://api.twitter.com/1.1/statuses/show.json?id=' . $tweetId;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $appToken
            ));
            $curl_result = curl_exec($ch);
            curl_close($ch);

            $tweet = CJSON::decode($curl_result, true);

            if (!empty($tweet['id'])) {
                $userDetail['tweet_id'] = $tweet['id'];
                if (isset($tweet['user']) && isset($tweet['user']['name']))
                    $userDetail['tweet_author'] = $tweet['user']['name'];
                if (isset($tweet['user']) && isset($tweet['user']['screen_name'])) {
                    $userDetail['tweet_username'] = $tweet['user']['screen_name'];
                    $userDetail['soc_url'] = 'https://twitter.com/' . $tweet['user']['screen_name'];
                } else
                    $userDetail['soc_url'] = 'https://twitter.com/' . self::parseUsername($link);
                if (isset($tweet['user']) && isset($tweet['user']['followers_count']))
                    $userDetail['followers_count'] = $tweet['user']['followers_count'];
                if (isset($tweet['text']))
                    $userDetail['tweet_text'] = $tweet['text'];
                if (isset($tweet['user']) && isset($tweet['user']['profile_image_url']))
                    $userDetail['photo'] = $tweet['user']['profile_image_url'];
                if (isset($tweet['created_at']))
                    $userDetail['tweet_datetime'] = date('g:i A - j M y', strtotime($tweet['created_at']));
            } else
                $userDetail['error'] = Yii::t('social', "This post doesn't exist:") . $link;
        } else {
            //профиль
            $socUsername = self::parseUsername($link);

            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json?count=1';
            if (is_numeric($socUsername))
                $url .= '&user_id=' . $socUsername;
            else
                $url .= '&screen_name=' . $socUsername;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $appToken
            ));
            $curl_result = curl_exec($ch);
            curl_close($ch);
            $userFeed = CJSON::decode($curl_result, true);

            if (isset($userFeed[0]) && !empty($userFeed[0]['id'])) {
                $userDetail['tweet_id'] = $userFeed[0]['id'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['name']))
                    $userDetail['tweet_author'] = $userFeed[0]['user']['name'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['screen_name']))
                    $userDetail['tweet_username'] = $userFeed[0]['user']['screen_name'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['followers_count']))
                    $userDetail['followers_count'] = $userFeed[0]['user']['followers_count'];
                if (isset($userFeed[0]['text']))
                    $userDetail['tweet_text'] = $userFeed[0]['text'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['profile_image_url']))
                    $userDetail['photo'] = $userFeed[0]['user']['profile_image_url'];
                if (isset($userFeed[0]['created_at']))
                    $userDetail['tweet_datetime'] = date('g:i A - j M y', strtotime($userFeed[0]['created_at']));

                if (isset($userFeed[0]['user']) and !empty($userFeed[0]['user']['screen_name']))
                    $userDetail['soc_url'] = 'https://twitter.com/' . $userFeed[0]['user']['screen_name'];
            }
        }

        return $userDetail;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'twitter.com/') !== false) {
            $username = substr($username, (strpos($username, 'twitter.com/') + 12));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function contentNeedSave($link)
    {
        $result = false;
        if ((strpos($link, 'twitter.com/') !== false) and (strpos($link, '/status/') !== false))
            $result = true;
        return $result;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['twitter_id']))
            $answer = true;

        return $answer;
    }

    public static function parseOAuthToken($tokenString)
    {
        $tokenAndSecret = array();

        $tokenAndSecret['token'] = self::parseParam($tokenString, 'oauth_token=');
        $tokenAndSecret['secret'] = self::parseParam($tokenString, 'oauth_token_secret=');

        return $tokenAndSecret;
    }

    public static function checkToken($user_token, $token_secret)
    {
        $is_valid = null;

        $url = "https://api.twitter.com/1.1/account/verify_credentials.json";

        $oauth = array('oauth_consumer_key' => Yii::app()->eauth->services['twitter']['key'],
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $user_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0');

        $base_info = self::buildBaseString($url, 'GET', $oauth);
        $composite_key = rawurlencode(Yii::app()->eauth->services['twitter']['secret']) . '&' . rawurlencode($token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $header = array(self::buildAuthorizationHeader($oauth));
        $options = array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0',
            CURLOPT_CAINFO => Yii::app()->params['ssl'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );

        $feed = curl_init();
        curl_setopt_array($feed, $options);
        $json = curl_exec($feed);
        curl_close($feed);

        $twitter_data = json_decode($json, true);

        if (!empty($twitter_data['id']))
            $is_valid = true;
        else if (isset($twitter_data['errors']) && isset($twitter_data['errors'][0]) && isset($twitter_data['errors'][0]['code']) && 89 == $twitter_data['errors'][0]['code'])
            $is_valid = false;

        return $is_valid;
    }

    public static function buildAuthorizationHeader($oauth)
    {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach ($oauth as $key => $value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        $r .= implode(', ', $values);
        return $r;
    }

    public static function buildBaseString($baseURI, $method, $params)
    {
        $r = array();
        ksort($params);
        foreach ($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    public static function checkSharing($loyalty)
    {
        $answer = false;

        $link = $loyalty->getLink();
        if (empty($link))
            return false;

        switch($loyalty->sharing_type) {
            /*
            case Loyalty::TWITTER_SHARE:
                $answer = self::checkTwitSharing($link);
            break;
            */
            case Loyalty::TWITTER_RETWIT:
                $answer = self::checkRetwit($link);
            break;
            case Loyalty::TWITTER_READING:
                $answer = self::checkReading($link);
            break;
            case Loyalty::TWITTER_HASHTAG:
                $answer = self::checkHashtag($link);
            break;
        }

        return $answer;
    }

    public static function checkRetwit($link)
    {
        $answer = false;

        Yii::import('ext.twitteroauth.TwitterOAuth');

        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocToken::TYPE_TWITTER,
        ));

        if (!$socToken)
            return false;

        $settings = array(
            'oauth_access_token' => $socToken->user_token,
            'oauth_access_token_secret' => $socToken->token_secret,
            'consumer_key' => Yii::app()->eauth->services['twitter']['key'],
            'consumer_secret' => Yii::app()->eauth->services['twitter']['secret']
        );
        $tweetId = self::parseParam($link, '/status/');

        $connection = new TwitterOAuth(
            Yii::app()->eauth->services['twitter']['key'],
            Yii::app()->eauth->services['twitter']['secret'], $socToken->user_token,
            $socToken->token_secret
        );
        $tweet = $connection->get(
            'statuses/show',
            array(
                'id' => $tweetId,
                'include_my_retweet'=>'true',
                'include_entities'=>'false')
        );

        if (!empty($tweet->retweeted) and '1' == $tweet->retweeted)
            $answer = true;

        return $answer;
    }

    public static function checkReading($link)
    {
        $answer = false;

        Yii::import('ext.twitteroauth.TwitterOAuth');

        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocToken::TYPE_TWITTER,
        ));

        if (!$socToken)
            return false;

        $reading_name = self::parseParam($link, 'twitter.com/');

        $connection = new TwitterOAuth(
            Yii::app()->eauth->services['twitter']['key'],
            Yii::app()->eauth->services['twitter']['secret'], $socToken->user_token,
            $socToken->token_secret
        );

        $friendship = $connection->get(
            'friendships/show',
            array(
                'source_screen_name' => $socToken->soc_username, 'target_screen_name' => $reading_name
            )
        );

        if (
            !empty($friendship->relationship)
            and !empty($friendship->relationship->source)
            and !empty($friendship->relationship->source->following)
            and '1' == $friendship->relationship->source->following
        )
            $answer = true;

        return $answer;
    }

    public static function checkHashtag($link)
    {
        $answer = false;

        Yii::import('ext.twitteroauth.TwitterOAuth');

        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocToken::TYPE_TWITTER,
        ));

        if (!$socToken)
            return false;

        $hashtag = self::parseParam($link, '#');

        $params = array(
            'q' => $hashtag . ' from:'.$socToken->soc_username,
            'count' => 1,
        );

        $connection = new TwitterOAuth(
            Yii::app()->eauth->services['twitter']['key'],
            Yii::app()->eauth->services['twitter']['secret'], $socToken->user_token,
            $socToken->token_secret
        );

        $search = $connection->get('search/tweets', $params);
        if (!empty($search->statuses) and !empty($search->statuses[0]))
            $answer = true;

        return $answer;
    }
}
