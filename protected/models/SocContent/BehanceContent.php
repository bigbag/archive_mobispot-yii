<?php


class BehanceContent extends SocContentBase
{

    public static function isLinkCorrect($link)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        


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