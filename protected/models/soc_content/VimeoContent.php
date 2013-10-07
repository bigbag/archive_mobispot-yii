<?php

class VimeoContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $socUser = self::makeRequest('http://vimeo.com/api/v2/' . $socUsername . '/info.json');
        if (is_string($socUser) || !isset($socUser['id']))
        {
            $video = self::makeRequest('http://vimeo.com/api/v2/video/' . $socUsername . '.json');
            if (is_string($video) || !isset($video[0]))
            {
                $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
        }

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);
        
        $socUser = self::makeRequest('http://vimeo.com/api/v2/' . $socUsername . '/info.json');
        if (!is_string($socUser) && isset($socUser['id']))
        {
            if (!empty($socUser['display_name']))
                $userDetail['soc_username'] = $socUser['display_name'];
            if (!empty($socUser['profile_url']))
                $userDetail['soc_url'] = $socUser['profile_url'];
            if (!empty($socUser['profile_url']) && !empty($socUser['display_name']))
                $userDetail['sub-line'] = ' from <a href="'. $socUser['profile_url'] .'">' 
                    . $socUser['display_name'] . '</a> on <a href="http://vimeo.com">Vimeo</a> </span>';
            
            if (!empty($socUser['portrait_medium']))
                $userDetail['photo'] = $socUser['portrait_medium'];
            elseif (!empty($socUser['portrait_small']))
                $userDetail['photo'] = $socUser['portrait_small'];
            $video = self::makeRequest('http://vimeo.com/api/v2/' . $socUsername . '/videos.json');

            if (isset($video[0]) && isset($video[0]['id']))
            {
                $userDetail['vimeo_last_video'] = $video[0]['id'];
                if (isset($video[0]['video_stats_number_of_plays']))
                    $userDetail['vimeo_last_video_counter'] = $video[0]['video_stats_number_of_plays'];
                elseif (isset($video[0]['stats_number_of_plays']))
                    $userDetail['vimeo_last_video_counter'] = $video[0]['stats_number_of_plays'];
                if (!empty($video[0]['title']))
                    $userDetail['soc_username'] = $video[0]['title'];
            }
            if (isset($video[0]['width']) && isset($video[0]['height']))
            {
                $userDetail['vimeo_video_width'] = $video[0]['width'];
                $userDetail['vimeo_video_height'] = $video[0]['height'];
            }
        }
        else
        {
            $video = self::makeRequest('http://vimeo.com/api/v2/video/' . $socUsername . '.json');

            if (!is_string($video) && isset($video[0]))
            {
                if (!empty($video[0]['title']))
                    $userDetail['soc_username'] = $video[0]['title'];
                elseif (!empty($video[0]['user_name']))
                    $userDetail['soc_username'] = $video[0]['user_name'];
                if (!empty($video[0]['url']))
                    $userDetail['soc_url'] = $video[0]['url'];
                if (!empty($video[0]['user_url']) && !empty($video[0]['user_name']))
                    $userDetail['sub-line'] = ' from <a href="'. $video[0]['user_url'] .'">' 
                        . $video[0]['user_name'] . '</a> on <a href="http://vimeo.com">Vimeo</a> </span>';
                if (!empty($video[0]['user_portrait_medium']))
                    $userDetail['photo'] = $video[0]['user_portrait_medium'];
                elseif (!empty($video[0]['user_portrait_small']))
                    $userDetail['photo'] = $video[0]['user_portrait_small'];
                $userDetail['vimeo_last_video'] = $socUsername;
                if (isset($video[0]['video_stats_number_of_plays']))
                    $userDetail['vimeo_last_video_counter'] = $video[0]['video_stats_number_of_plays'];
                elseif (isset($video[0]['stats_number_of_plays']))
                    $userDetail['vimeo_last_video_counter'] = $video[0]['stats_number_of_plays'];
                if (isset($video[0]['width']) && isset($video[0]['height']))
                {
                    $userDetail['vimeo_video_width'] = $video[0]['width'];
                    $userDetail['vimeo_video_height'] = $video[0]['height'];
                }
            }
            else
            {
                $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
        }
    
        return $userDetail;
    }
    
    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'vimeo.com/') !== false)
        {
            $username = substr($username, (strpos($username, 'vimeo.com/') + 10));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['vimeo_id']))
            $answer = true;
        
        return $answer;
    }
}