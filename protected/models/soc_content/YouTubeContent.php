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

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = $link;
        
        //$userXML = $self::makeRequest('http://gdata.youtube.com/feeds/api/users/'.$socUsername);
        $username = '';
        if ((strpos($socUsername, 'youtube.com/channel/') > 0) || (strpos($socUsername, 'youtube.com/channel/') !== false))
            $username = substr($socUsername, (strpos($socUsername, 'youtube.com/channel/') + 20));
        if ((strpos($socUsername, 'youtube.com/user/') > 0) || (strpos($socUsername, 'youtube.com/user/') !== false))
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

                //$userDetail['soc_username'] = $userProfileEntry->title->text;
                $userDetail['photo'] = $userProfileEntry->getThumbnail()->getUrl();
                /*
                $userDetail['age'] = $userProfileEntry->getAge();
                $userDetail['gender'] = $userProfileEntry->getGender();
                $userDetail['location'] = $userProfileEntry->getLocation();
                $userDetail['school'] = $userProfileEntry->getSchool();
                $userDetail['work'] = $userProfileEntry->getCompany();
                $userDetail['about'] = $userProfileEntry->getOccupation();
                */
                
                $videoFeed = $yt->getuserUploads($username);

                if (isset($videoFeed[0]))
                {
                    $videoEntry = $videoFeed[0];
                    $userDetail['ytube_video_link'] = '<a href="' . $videoEntry->getVideoWatchPageUrl() . '" target="_blank">' . $videoEntry->getVideoTitle() . '</a>';
                    $userDetail['ytube_video_flash'] = $videoEntry->getFlashPlayerUrl();
                    $userDetail['ytube_video_view_count'] = $videoEntry->getVideoViewCount();

                    $videoThumbnails = $videoEntry->getVideoThumbnails();
                    if (isset($videoThumbnails[0]) && isset($videoThumbnails[0]['width']) && isset($videoThumbnails[0]['height']))
                    {
                        $userDetail['ytube_video_rel'] = $videoThumbnails[0]['width'] / $videoThumbnails[0]['height'];
                    }
                }
            } catch (Exception $e)
            {
                $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
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
                    $userDetail['ytube_video_link'] = '<a href="' . $videoEntry->getVideoWatchPageUrl() . '" target="_blank">' . $videoEntry->getVideoTitle() . '</a>';
                    $userDetail['ytube_video_flash'] = $videoEntry->getFlashPlayerUrl();
                    $userDetail['ytube_video_view_count'] = $videoEntry->getVideoViewCount();

                    $videoThumbnails = $videoEntry->getVideoThumbnails();
                    if (isset($videoThumbnails[0]))
                    {
                        $userDetail['ytube_video_rel'] = $videoThumbnails[0]['width'] / $videoThumbnails[0]['height'];
                    }
                } catch (Exception $e)
                {
                    $userDetail['soc_username'] = Yii::t('eauth', "This post doesn't exist:") . $socUsername;
                }
            }
        }
        $userDetail['avatar_before_mess_body'] = true;
        
        return $userDetail;
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