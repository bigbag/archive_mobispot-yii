<?php

class InstagramContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $socUser = self::makeRequest('https://api.instagram.com/v1/users/search?q=' . $socUsername . '&count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
        if (is_string($socUser) || !isset($socUser['data']) || !isset($socUser['data'][0]))
        {
            $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");
        }

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'instagram.com/') !== false)
            $username = substr($username, (strpos($username, 'instagram.com/') + 14));
        $username = self::rmGetParam($username);

        return $username;
    }

}