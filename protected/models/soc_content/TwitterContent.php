<?php

class TwitterContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';

        //$appToken = Yii::app()->cache->get('twitterAppToken');
        $appToken = false;
        if ($appToken === false)
        {
            $credentials = base64_encode(urlencode(Yii::app()->eauth->services['twitter']['key']) . ':' . urlencode(Yii::app()->eauth->services['twitter']['secret']));
            $url = 'https://api.twitter.com/oauth2/token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
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

        if ((strpos($link, 'twitter.com/') !== false) && (strpos($link, '/status/') !== false))
        {
            //твитт
        }
        else
        {
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
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $appToken
            ));
            $curl_result = curl_exec($ch);
            curl_close($ch);
            $socUser = CJSON::decode($curl_result, true);

            if (!empty($socUser['error']) || empty($socUser['id']))
            {
                $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
        }

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        
        //$appToken = Yii::app()->cache->get('twitterAppToken');
        $appToken = false;
        if ($appToken === false)
        {
            $credentials = base64_encode(urlencode(Yii::app()->eauth->services['twitter']['key']) . ':' . urlencode(Yii::app()->eauth->services['twitter']['secret']));
            $url = 'https://api.twitter.com/oauth2/token';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
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

        if ((strpos($link, 'twitter.com/') !== false) && (strpos($link, '/status/') !== false))
        {
            //твитт
            $tweetId = substr($link, (strpos($link, '/status/') + 8));
            $tweetId = self::rmGetParam($tweetId);
        
            $url = 'https://api.twitter.com/1.1/statuses/show.json?id=' . $tweetId;
             $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $appToken
            ));
            $curl_result = curl_exec($ch);
            curl_close($ch);
            
            $tweet = CJSON::decode($curl_result, true);
        
            if (!empty($tweet['id']))
            {
                $userDetail['tweet_id'] = $tweet['id'];
                if (isset($tweet['user']) && isset($tweet['user']['name']))
                    $userDetail['tweet_author'] = $tweet['user']['name'];
                if (isset($tweet['user']) && isset($tweet['user']['screen_name']))
                {
                    $userDetail['tweet_username'] = $tweet['user']['screen_name'];
                    $userDetail['soc_url'] = 'https://twitter.com/' . $tweet['user']['screen_name'];
                }
                else
                    $userDetail['soc_url'] = 'https://twitter.com/' . self::parseUsername($link);
                if (isset($tweet['text']))
                    $userDetail['tweet_text'] = $tweet['text'];
                if (isset($tweet['user']) && isset($tweet['user']['profile_image_url']))
                    $userDetail['photo'] = $tweet['user']['profile_image_url'];
                if (isset($tweet['created_at']))
                    $userDetail['tweet_datetime'] = date('g:i A - j M y', strtotime($tweet['created_at']));
            }
            else
                $userDetail['error'] =  Yii::t('eauth', "This post doesn't exist:") . $link;
        }
        else
        {
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
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer ' . $appToken
            ));
            $curl_result = curl_exec($ch);
            curl_close($ch);
            $userFeed = CJSON::decode($curl_result, true);

            if (isset($userFeed[0]) && !empty($userFeed[0]['id']))
            {
                $userDetail['tweet_id'] = $userFeed[0]['id'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['name']))
                    $userDetail['tweet_author'] = $userFeed[0]['user']['name'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['screen_name']))
                    $userDetail['tweet_username'] = $userFeed[0]['user']['screen_name'];
                if (isset($userFeed[0]['text']))
                    $userDetail['tweet_text'] = $userFeed[0]['text'];
                if (isset($userFeed[0]['user']) && isset($userFeed[0]['user']['profile_image_url']))
                    $userDetail['photo'] = $userFeed[0]['user']['profile_image_url'];
                if (isset($userFeed[0]['created_at']))
                    $userDetail['tweet_datetime'] = date('g:i A - j M y', strtotime($userFeed[0]['created_at']));
            }
        }

        return $userDetail;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'twitter.com/') !== false)
        {
            $username = substr($username, (strpos($username, 'twitter.com/') + 12));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function contentNeedSave($link)
    {
        $result = false;
        if ((strpos($link, 'twitter.com/') !== false) && (strpos($link, '/status/') !== false))
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
}