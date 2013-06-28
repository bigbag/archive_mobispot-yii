<?php

class LinkedInContent extends SocContentBase
{

    public static function isLinkCorrect($link)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        
        return $result;
    }

    public static function parseUsername($link){
        $username = $link;
        return $username;
    }
}