<?php

class GoogleContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';
        $ch = curl_init('https://www.googleapis.com/plus/v1/people/' . $socUsername . '?key=' . Yii::app()->eauth->services['google_oauth']['key']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);

        $curl_result = curl_exec($ch);
        curl_close($ch);

        $socUser = CJSON::decode($curl_result, true);
        if (empty($socUser['id']) || !empty($socUser['error']) || !empty($socUser['errors']))
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);
        
        $url = 'https://www.googleapis.com/plus/v1/people/' . $socUsername . '?key=' . Yii::app()->eauth->services['google_oauth']['key'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);
        //curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/../config/ca-bundle.crt');

        $curl_result = curl_exec($ch);
        curl_close($ch);

        $socUser = CJSON::decode($curl_result, true);

        if (!isset($socUser['error']) && isset($socUser['id']))
        {
            $userDetail['UserExists'] = true;
            if (isset($socUser['displayName']))
                $userDetail['soc_username'] = $socUser['displayName'];
            if (isset($socUser['image']) && isset($socUser['image']['url']))
                $userDetail['photo'] = $socUser['image']['url'];
            if (isset($socUser['name']) && isset($socUser['name']['givenName']))
                $userDetail['first_name'] = $socUser['name']['givenName'];
            if (isset($socUser['name']) && isset($socUser['name']['familyName']))
                $userDetail['last_name'] = $socUser['name']['familyName'];
            /*
              if(isset($socUser['gender']))
              $userDetail['gender'] = $socUser['gender'];
              if(isset($socUser['placesLived'])){
              foreach($socUser['placesLived'] as $place){
              if(isset($place['primary']) && ($place['primary']==true))
              $userDetail['location'] = $place['value'];
              }
              }
              if(isset($socUser['organizations'])){
              foreach($socUser['organizations'] as $org){
              if(isset($org['primary']) && ($org['primary']==true)){
              if($org['type'] == 'work')
              $userDetail['work'] = $org['name'];
              else if($org['type'] == 'school')
              $userDetail['school'] = $org['name'];
              }
              }

              }
              if(isset($socUser['aboutMe']))
              $userDetail['about'] = $socUser['aboutMe'];
              if(isset($socUser['url']))
              $userDetail['soc_url'] = $socUser['url'];
             */
            //Последний пост
            $url = 'https://www.googleapis.com/plus/v1/people/' . $socUsername . '/activities/public?key=' . Yii::app()->eauth->services['google_oauth']['key'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->eauth->services['ssl']['path']);

            $curl_result = curl_exec($ch);
            curl_close($ch);

            //$userFeed = CJSON::decode($curl_result, true);
            $userFeed = json_decode($curl_result, true);

            unset($lastPost);
            $i = 0;
            $prevPageUrl = '';

            while (!isset($lastPost))
            {
                if (isset($userFeed['items']) && isset($userFeed['items'][$i]) && isset($userFeed['items'][$i]['actor']) && isset($userFeed['items'][$i]['actor']['id']) && ($userFeed['items'][$i]['actor']['id'] == $socUser['id']) && isset($userFeed['items'][$i]['object']))
                {
                    $lastPost = $userFeed['items'][$i];
                }
                elseif (!isset($userFeed['items']) || (!isset($userFeed['items'][$i])))
                {
                    $lastPost = 'no';
                }
                else
                {
                    $i++;
                }
            }

            if ($lastPost != 'no')
            {
                if (isset($lastPost['object']['content']))
                    $userDetail['last_status'] = strip_tags($lastPost['object']['content'], '<p><br>');
                $userDetail['sub-line'] = '';
                if (isset($lastPost['access']) && !empty($lastPost['access']['description']) && ($lastPost['access']['description'] == 'Public'))
                {
                    $userDetail['sub-line'] = Yii::t('eauth', 'Available to everyone');
                }
                if (!empty($lastPost['published']))
                {
                    if (empty($userDetail['sub-line']))
                        $userDetail['sub-line'] = date('F j, Y', strtotime($lastPost['published']));
                    else
                        $userDetail['sub-line'] .= ' - ' . date('F j, Y', strtotime($lastPost['published']));
                }

                //Картинка
                if (isset($lastPost['object']['attachments']))
                {
                    $i = 0;
                    unset($imgSrc);
                    while (isset($lastPost['object']['attachments'][$i]) && !isset($imgSrc))
                    {
                        if (isset($lastPost['object']['attachments'][$i]['image']) && isset($lastPost['object']['attachments'][$i]['image']['url']) && (strlen($lastPost['object']['attachments'][$i]['image']['url']) > 0) && ($lastPost['object']['attachments'][$i]['image']['url'] != ' https:'))
                        {
                            $imgSrc = $lastPost['object']['attachments'][$i]['image']['url'];
                        }
                        else
                            $i++;
                    }
                    if (isset($imgSrc))
                    {
                        $userDetail['last_img'] = $imgSrc;
                        if (isset($lastPost['object']['attachments'][$i]['displayName']) && (strlen($lastPost['object']['attachments'][$i]['displayName']) > 0))
                            $userDetail['last_img_msg'] = strip_tags($lastPost['object']['attachments'][$i]['displayName'], '<p><br>');
                        elseif (isset($lastPost['object']['attachments'][$i]['content']) && (strlen($lastPost['object']['attachments'][$i]['content']) > 0))
                            $userDetail['last_img_msg'] = strip_tags($lastPost['object']['attachments'][$i]['content'], '<p><br>');
                        elseif (isset($userDetail['last_status']))
                        {
                            $userDetail['last_img_msg'] = $userDetail['last_status'];
                            unset($userDetail['last_status']);
                        }
                        if (isset($lastPost['object']['attachments'][$i]['url']))
                            $userDetail['last_img_href'] = $lastPost['object']['attachments'][$i]['url'];
                    }
                }
            }
        }else
        {
            $userDetail['error'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }
    
        return $userDetail;
    }
    
    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'google.com') !== false)
        {
            if (strpos($username, 'google.com/u/0/') !== false)
            {
                $username = substr($username, (strpos($username, 'google.com/u/0/') + 15));
            }
            if (strpos($username, 'google.com/') !== false)
            {
                $username = substr($username, (strpos($username, 'google.com/') + 11));
            }
            $username = self::rmGetParam($username);
        }
        return $username;
    }
    
    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['google_oauth_id']))
            $answer = true;
        
        return $answer;
    }
}