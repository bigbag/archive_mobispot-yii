<?php


class FoursquareContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        $socId = $socUsername;
        
        if(!is_numeric($socId)){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://foursquare.com/'.$socId);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
            $profile = curl_exec($ch);
            curl_close($ch);
            $match = array();
            preg_match('~user: {"id":"[0-9]+","firstName":~', $profile, $match);
            if(isset($match[0]) && (strpos($match[0], 'user: {"id":"') !== false)){
            $socId = str_replace('user: {"id":"', '', $match[0]);
            $socId = str_replace('","firstName":', '', $socId);
            }
        }
        
        $socUser = self::makeRequest('https://api.foursquare.com/v2/users/'.$socId.'?client_id='.Yii::app()->eauth->services['foursquare']['client_id'].'&client_secret='.Yii::app()->eauth->services['foursquare']['client_secret'].'&v=20130211');
        if(!is_array($socUser) || empty($socUser['response']) || empty($socUser['response']['user']))
            $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if(strpos($username, 'foursquare.com/user/') !== false){
            $username = substr($username, (strpos($username, 'foursquare.com/user/')+20));
        }
        if(strpos($username, 'foursquare.com') !== false){
            $username = substr($username, (strpos($username, 'foursquare.com')+15));
        }
        $username = self::rmGetParam($username);
        return $username;
    }
}