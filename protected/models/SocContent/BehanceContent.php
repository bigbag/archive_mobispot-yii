<?php


class BehanceContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        
        $options = array();
        $socUser = self::makeRequest('http://www.behance.net/v2/users/'.$socUsername.'?api_key='.Yii::app()->eauth->services['behance']['client_id'], $options, false);
        if(strpos($socUser, 'error:') !== false)
            $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if(strpos($username, 'behance.net/') !== false){
            $username = substr($username, (strpos($username, 'behance.net/')+ 12));
            $username = self::rmGetParam($username);
        }
        return $username;
    }
}