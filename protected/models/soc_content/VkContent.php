<?php

class VkContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $url = 'https://api.vk.com/method/users.get.json?uids=' . $socUsername;
        $socUser = self::makeRequest($url);
        if (empty($socUser['response']) || empty($socUser['response'][0]) || empty($socUser['response'][0]['uid']))
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'vk.com/') !== false)
        {
            $username = substr($username, (strpos($username, 'vk.com/') + 7));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['vk_id']))
            $answer = true;
        
        return $answer;
    }
}