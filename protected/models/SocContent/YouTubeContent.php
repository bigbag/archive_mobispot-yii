<?php

class GoogleContent extends SocContentBase
{

    public static function isLinkCorrect($link)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
      
        return $result;
    }

    public static function parseUsername($link){
      $username = $link;
    /*
        if((strpos($username, 'youtube.com/channel/') > 0) ||(strpos($username, 'youtube.com/channel/') !== false)){
            $username = substr($username, (strpos($username, 'youtube.com/channel/') + 20));
            $username = self::rmGetParam($username);
        }
        if((strpos($username, 'youtube.com/user/') > 0) ||(strpos($username, 'youtube.com/user/') !== false)){
            $username = substr($username, (strpos($username, 'youtube.com/user/') + 17));
            $username = self::rmGetParam($username);
        }
    */
      return $username;
    }
    
    
}