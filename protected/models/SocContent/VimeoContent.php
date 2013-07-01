<?php


class VimeoContent extends SocContentBase
{

    public static function isLinkCorrect($link)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        
        $socUser = self::makeRequest('http://vimeo.com/api/v2/'.$socUsername.'/info.json');
        if(is_string($socUser) || !isset($socUser['id'])){
            $video = self::makeRequest('http://vimeo.com/api/v2/video/'.$socUsername.'.json');
            if(is_string($video) || !isset($video[0])){
                $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");
            }
        }

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if(strpos($username, 'vimeo.com/') !== false){
            $username = substr($username, (strpos($username, 'vimeo.com/')+10));
            $username = self::rmGetParam($username);
        }
        return $username;
    }
}