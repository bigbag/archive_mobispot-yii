<?php

class TwitterContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
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
            $appToken = $curl_result['access_token'];
            //Yii::app()->cache->set('twitterAppToken', $appToken);
        }

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
            $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");
        }

        return $result;
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

}