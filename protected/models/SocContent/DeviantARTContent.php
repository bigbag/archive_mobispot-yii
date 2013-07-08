<?php

class DeviantARTContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $options = array();
        $ch = self::initRequest('http://' . $socUsername . '.deviantart.com', $options);
        $socUser = curl_exec($ch);
        $headers = curl_getinfo($ch);
        if ($headers['http_code'] != 200)
        {
            $result = Yii::t('eauth', "Такого профиля не существует: $socUsername");
        }

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'http://') !== false)
            $username = substr($username, (strpos($username, 'http://') + 7));
        if (strpos($username, 'deviantart.com') !== false)
            $username = substr($username, 0, (strpos($username, 'deviantart.com') - 1));
        if (strpos($username, 'http://') !== false)
            $username = 'strpos:' . strpos($username, 'http://');
        return $username;
    }

}