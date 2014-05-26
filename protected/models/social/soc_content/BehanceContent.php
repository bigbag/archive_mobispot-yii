<?php

class BehanceContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $options = array();
        $socUser = self::makeRequest('http://www.behance.net/v2/users/' . $socUsername . '?api_key=' . Yii::app()->eauth->services['behance']['client_id'], $options, false);
        if (strpos($socUser, 'error:') !== false)
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'behance.net/') !== false)
        {
            $username = substr($username, (strpos($username, 'behance.net/') + 12));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $userDetail['block_type'] = self::TYPE_POST;
        $socUsername = self::parseUsername($link);

        $socUser = self::makeRequest('http://www.behance.net/v2/users/' . $socUsername . '?api_key=' . Yii::app()->eauth->services['behance']['client_id']);

        if (!(is_string($socUser) && (strpos($socUser, 'error:') !== false)) && !empty($socUser['user']))
        {
            $socUser = $socUser['user'];
            if (!empty($socUser['display_name']))
                $userDetail['soc_username'] = $socUser['display_name'];
            else
                $userDetail['soc_username'] = $socUser['username'];
            if (!empty($socUser['images']) && !empty($socUser['images']['50']))
                $userDetail['photo'] = $socUser['images']['50'];
            $userDetail['soc_url'] = $socUser['url'];
            /*
              if(!empty($socUser['sections']['Where, When and What']))
              $userDetail['about'] = $socUser['sections']['Where, When and What'];
              if(!empty($socUser['company']))
              $userDetail['work'] = $socUser['company'];
              if(!empty($socUser['country']))
              $userDetail['location'] = $socUser['country'];
              else
              $userDetail['location'] = '';
              if(!empty($socUser['state'])){
              if($userDetail['location'] == '')
              $userDetail['location'] = $socUser['state'];
              else
              $userDetail['location'] .= ', '.$socUser['state'];
              }
              if(!empty($socUser['city'])){
              if($userDetail['location'] == '')
              $userDetail['location'] = $socUser['city'];
              else
              $userDetail['location'] .= ', '.$socUser['city'];
              }
              if($userDetail['location'] == '')
              unset($userDetail['location']);
              if(!empty($socUser['fields'][0])){
              $userDetail['focus'] = '';
              foreach($socUser['fields'] as $focus){
              if($userDetail['focus'] !== '')
              $userDetail['focus'] .= ', ';
              $userDetail['focus'] .= $focus;
              }
              }
              }
             */

            $projects = self::makeRequest('http://www.behance.net/v2/users/' . $socUsername . '/projects?api_key=' . Yii::app()->eauth->services['behance']['client_id']);
            if (!(is_string($projects) && (strpos($projects, 'error:') !== false)) && isset($projects['projects']) && !empty($projects['projects'][0]))
            {
                $project = $projects['projects'][0];
                if (!empty($project['covers']))
                {
                    $maxSize = 0;
                    foreach ($project['covers'] as $size => $img)
                    {
                        if ($size > $maxSize)
                        {
                            $userDetail['last_img'] = $img;
                            $maxSize = $size;
                        }
                    }
                }
                if (!empty($project['url']))
                    $userDetail['last_img_href'] = $project['url'];
                if (!empty($project['name']))
                    $userDetail['last_img_msg'] = $project['name'];
                if (!empty($project['published_on']))
                    $userDetail['sub-time'] = date('F d, Y', $project['published_on']);
                if (isset($project['owners']) && isset($project['owners'][0]))
                {
                    $place = '';
                    if (!empty($project['owners'][0]['city']))
                        $place .= $project['owners'][0]['city'];
                    if (!empty($project['owners'][0]['state']) && !(!empty($project['owners'][0]['city']) && $project['owners'][0]['city'] == $project['owners'][0]['state']))
                    {
                        if ($place)
                            $place .= ', ' . $project['owners'][0]['state'];
                        else
                            $place .= $project['owners'][0]['state'];
                    }
                    if (!empty($project['owners'][0]['country']))
                    {
                        if ($place)
                            $place .= ', ' . $project['owners'][0]['country'];
                        else
                            $place .= $project['owners'][0]['country'];
                    }
                    if ($place)
                        $userDetail['sub-line'] = '<span class="icon">&#xe01b;</span>' . $place;
                }
            }
        }
        else
        {
            $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }
        
        $userDetail['text'] = self::clueImgText($userDetail);
        
        return $userDetail;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['Behance_id']))
            $answer = true;

        return $answer;
    }

}
