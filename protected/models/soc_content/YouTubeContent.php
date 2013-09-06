<?php

class YouTubeContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = $link;
        $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        $result = 'ok';

        $username = '';
        if (strpos($socUsername, 'youtube.com/channel/') !== false)
            $username = substr($socUsername, (strpos($socUsername, 'youtube.com/channel/') + 20));
        if (strpos($socUsername, 'youtube.com/user/') !== false)
            $username = substr($socUsername, (strpos($socUsername, 'youtube.com/user/') + 17));
        if (strlen($username) > 0)
        {
            $username = self::rmGetParam($username);

            Yii::import('ext.ZendGdata.library.*');
            require_once('Zend/Gdata/YouTube.php');
            require_once('Zend/Gdata/AuthSub.php');

            $yt = new Zend_Gdata_YouTube();
            $yt->setMajorProtocolVersion(2);
            try
            {
                $userProfileEntry = $yt->getUserProfile($username);
                $result = 'ok';
            } catch (Exception $e)
            {
                $result = Yii::t('eauth', "Такого профиля не существует:") . $socUsername;
            }
        }
        else
        {
            $videoId = '';
            if ((strpos($socUsername, 'youtube.com') !== false) && (strpos($socUsername, 'watch?v=') !== false))
            {
                $videoId = substr($socUsername, (strpos($socUsername, 'watch?v=') + 8));

                Yii::import('ext.ZendGdata.library.*');
                require_once('Zend/Gdata/YouTube.php');
                require_once('Zend/Gdata/AuthSub.php');

                $yt = new Zend_Gdata_YouTube();
                $yt->setMajorProtocolVersion(2);
                try
                {
                    $videoEntry = $yt->getVideoEntry($videoId);
                    $result = 'ok';
                } catch (Exception $e)
                {
                    $result =  Yii::t('eauth', "This post doesn't exist:") . $videoId;
                }
            }
        }


        return $result;
    }

    public static function parseUsername($link)
    {
        return $link;
    }

    public static function isLoggegByNet()
    {
        //$answer = false;
        //if (!empty(Yii::app()->session['YouTube_id']))
            $answer = true;
        
        return $answer;
    }
}