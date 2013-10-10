<?php

class InstagramContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $socUser = self::makeRequest('https://api.instagram.com/v1/users/search?q=' . $socUsername . '&count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
        if (is_string($socUser) || !isset($socUser['data']) || !isset($socUser['data'][0]))
        {
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'instagram.com/') !== false)
            $username = substr($username, (strpos($username, 'instagram.com/') + 14));
        $username = self::rmGetParam($username);

        return $username;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);

        $socUser = self::makeRequest('https://api.instagram.com/v1/users/search?q=' . $socUsername . '&count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
        if (!is_string($socUser) && isset($socUser['data']) && isset($socUser['data'][0]))
        {
            $socUser = $socUser['data'][0];
            /* if(!empty($socUser['full_name']))
              $userDetail['soc_username'] = $socUser['full_name'];
              elseif(!empty($socUser['username']))
              $userDetail['soc_username'] = $socUser['username'];
             */
            if (!empty($socUser['username']))
                $userDetail['soc_url'] = 'http://instagram.com/' . $socUser['username'];
            /*  if(!empty($socUser['profile_picture']))
              $userDetail['photo'] = $socUser['profile_picture'];
             */

            $techSoc = SocToken::model()->findByAttributes(array(
                'type' => 10,
                'is_tech' => true
            ));

            if ($techSoc && isset($socUser['id']))
            {
                $media = self::makeRequest('https://api.instagram.com/v1/users/' . $socUser['id'] . '/media/recent?count=1&access_token=' . $techSoc->user_token);

                if (isset($media['data']) && isset($media['data'][0]))
                {
Yii::app()->session['debug'] = print_r($media['data'][0], true);
                    if (!empty($media['data'][0]['user']['profile_picture']))
                        $userDetail['photo'] = $media['data'][0]['user']['profile_picture'];
                    if (!empty($media['data'][0]['user']['full_name']))
                        $userDetail['soc_username'] = $media['data'][0]['user']['full_name'];
                    elseif (!empty($media['data'][0]['user']['username']))
                        $userDetail['soc_username'] = $media['data'][0]['user']['username'];
                    if (isset($media['data'][0]['location']) && !empty($media['data'][0]['location']['name']))
                        $userDetail['sub-line'] = '<span class="icon">&#xe018;</span>' . $media['data'][0]['location']['name'];
                    if (!empty($media['data'][0]['created_time']))
                    {
                        $dateDiff = time() - (int)$media['data'][0]['created_time'];
                        $userDetail['sub-time'] = SocContentBase::timeDiff($dateDiff);
                    }

                    if (isset($media['data'][0]['images']) && isset($media['data'][0]['images']['standard_resolution']) && !empty($media['data'][0]['images']['standard_resolution']['url']))
                        $userDetail['last_img'] = $media['data'][0]['images']['standard_resolution']['url'];
                    elseif (isset($media['data'][0]['images']) && isset($media['data'][0]['images']['thumbnail']) && !empty($media['data'][0]['images']['thumbnail']['url']))
                        $userDetail['last_img'] = $media['data'][0]['images']['thumbnail']['url'];
                    if (isset($media['data'][0]['caption']) && !empty($media['data'][0]['caption']['text']))
                        $userDetail['last_img_msg'] = $media['data'][0]['caption']['text'];
                    if (!empty($media['data'][0]['link']))
                        $userDetail['last_img_href'] = $media['data'][0]['link'];
                    if (isset($media['data'][0]['likes']) && isset($media['data'][0]['likes']['count']) && isset($media['data'][0]['likes']['data']) && isset($media['data'][0]['likes']['data'][0]) && !empty($media['data'][0]['likes']['data'][0]['username']) && !empty($media['data'][0]['likes']['data'][0]['full_name']))
                    {
                        $userDetail['likes-block'] = '<a class="authot-name" href="http://instagram.com/' . $media['data'][0]['likes']['data'][0]['username'] . '">' . $media['data'][0]['likes']['data'][0]['full_name'] . '</a>';
                        
                        if (isset($media['data'][0]['likes']['data'][1]) && !empty($media['data'][0]['likes']['data'][1]['username']) && !empty($media['data'][0]['likes']['data'][1]['full_name']))
                        {
                            if ($media['data'][0]['likes']['count'] > 2)
                                $userDetail['likes-block'] .= ', ';
                            else
                                $userDetail['likes-block'] .= ' '. Yii::t('eauth', 'and') . ' ';
                            $userDetail['likes-block'] .= '<a class="authot-name" href="http://instagram.com/' . $media['data'][0]['likes']['data'][1]['username'] . '">' . $media['data'][0]['likes']['data'][1]['full_name'] . '</a>';
                            if ($media['data'][0]['likes']['count'] > 2)
                                $userDetail['likes-block'] .= ' '. Yii::t('eauth', 'and') . ' <b>' . ($media['data'][0]['likes']['count'] - 2) . '</b> ' . Yii::t('eauth', 'others');
                        }
                        $userDetail['likes-block'] .= ' '.Yii::t('eauth', 'like this') . '.';
                    }
                }
            }
            /*
              $user=User::model()->findByAttributes(array(
              'instagram_id'=>$socUser['id']
              ));
              if($user && strlen($user->instagram_media_id > 0)){
              $media = self::makeRequest('https://api.instagram.com/v1/media/'.$user->instagram_media_id.'?client_id='.Yii::app()->eauth->services['instagram']['client_id']);
              if(isset($media['data'])){
              if(isset($media['data']['images']) && isset($media['data']['images']['standard_resolution']) && !empty($media['data']['images']['standard_resolution']['url']))
              $userDetail['last_img'] = $media['data']['images']['standard_resolution']['url'];
              elseif(isset($media['data']['images']) && isset($media['data']['images']['thumbnail']) && !empty($media['data']['images']['thumbnail']['url']))
              $userDetail['last_img'] = $media['data']['images']['thumbnail']['url'];
              if(isset($media['data']['caption']) && !empty($media['data']['caption']['text']))
              $userDetail['last_img_msg'] = $media['data']['caption']['text'];
              if(!empty($media['data']['link']))
              $userDetail['last_img_href'] = $media['data']['link'];
              }
              }
             */
        }
        else
            $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $userDetail;
    }
    
    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['instagram_id']))
            $answer = true;
        
        return $answer;
    }
}