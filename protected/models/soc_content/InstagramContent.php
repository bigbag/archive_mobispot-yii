<?php

class InstagramContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';

        if (!(strpos($link, 'instagram.com') !== false && (strpos($link, '/p/') !== false) && strlen($link) > (strpos($link, '/p/') + strlen('/p/'))))
        {
            $socUsername = self::parseUsername($link);
            $socUser = self::makeRequest('https://api.instagram.com/v1/users/search?q=' . $socUsername . '&count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
            if (is_string($socUser) || !isset($socUser['data']) || !isset($socUser['data'][0]))
            {
                $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
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
        unset($post);
        
        if (strpos($link, 'instagram.com') !== false && (strpos($link, '/p/') !== false) && strlen($link) > (strpos($link, '/p/') + strlen('/p/')))
        {
            //привязан пост
            $slug = substr($link, (strpos($link, '/p/') + strlen('/p/')));
            $slug = self::rmGetParam($slug);
            
            $postMeta = self::makeRequest('http://api.instagram.com/oembed?url=' . $link);
            if (!empty($postMeta['media_id']))
            {
                $postJSON = self::makeRequest('https://api.instagram.com/v1/media/' 
                    . $postMeta['media_id'] 
                    . '?client_id='
                    . Yii::app()->eauth->services['instagram']['client_id']);
                if (isset($postJSON['data']) && !empty($postJSON['data']['id']))
                    $post = $postJSON['data'];
            }
        }
        else
        {
            //привязан профиль
            $socUsername = self::parseUsername($link);

            $socUser = self::makeRequest('https://api.instagram.com/v1/users/search?q=' . $socUsername . '&count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
            if (!is_string($socUser) && isset($socUser['data']) && isset($socUser['data'][0]))
            {
                $socUser = $socUser['data'][0];
                if (!empty($socUser['username']))
                    $userDetail['soc_url'] = 'http://instagram.com/' . $socUser['username'];

                $techSoc = SocToken::model()->findByAttributes(array(
                    'type' => 10,
                    'is_tech' => true
                ));

                if ($techSoc && isset($socUser['id']))
                {
                    $media = self::makeRequest('https://api.instagram.com/v1/users/' . $socUser['id'] . '/media/recent?count=1&access_token=' . $techSoc->user_token);
                    if (isset($media['data']) && isset($media['data'][0]) && !empty($media['data'][0]['id']))
                        $post = $media['data'][0];
                }
            }
            else
                $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }
        
        if (isset($post))
        {
            if (!empty($post['user']['profile_picture']))
                $userDetail['photo'] = $post['user']['profile_picture'];
            if (!empty($post['user']['full_name']))
                $userDetail['soc_username'] = $post['user']['full_name'];
            elseif (!empty($post['user']['username']))
                $userDetail['soc_username'] = $post['user']['username'];
            if (isset($post['location']) && !empty($post['location']['name']))
                $userDetail['sub-line'] = '<span class="icon">&#xe018;</span>' . $post['location']['name'];
            if (!empty($post['created_time']))
            {
                $dateDiff = time() - (int)$post['created_time'];
                $userDetail['sub-time'] = SocContentBase::timeDiff($dateDiff);
            }

            if (isset($post['images']) && isset($post['images']['standard_resolution']) && !empty($post['images']['standard_resolution']['url']))
                $userDetail['last_img'] = $post['images']['standard_resolution']['url'];
            elseif (isset($post['images']) && isset($post['images']['thumbnail']) && !empty($post['images']['thumbnail']['url']))
                $userDetail['last_img'] = $post['images']['thumbnail']['url'];
            if (isset($post['caption']) && !empty($post['caption']['text']))
                $userDetail['last_img_msg'] = $post['caption']['text'];
            if (!empty($post['link']))
                $userDetail['last_img_href'] = $post['link'];
            if (isset($post['likes']) && isset($post['likes']['count']) && isset($post['likes']['data']) && isset($post['likes']['data'][0]) && !empty($post['likes']['data'][0]['username']) && !empty($post['likes']['data'][0]['full_name']))
            {
                $userDetail['likes-block'] = '<a class="authot-name" href="http://instagram.com/' . $post['likes']['data'][0]['username'] . '">' . $post['likes']['data'][0]['full_name'] . '</a>';
                
                if (isset($post['likes']['data'][1]) && !empty($post['likes']['data'][1]['username']) && !empty($post['likes']['data'][1]['full_name']))
                {
                    if ($post['likes']['count'] > 2)
                        $userDetail['likes-block'] .= ', ';
                    else
                        $userDetail['likes-block'] .= ' '. Yii::t('eauth', 'and') . ' ';
                    $userDetail['likes-block'] .= '<a class="authot-name" href="http://instagram.com/' . $post['likes']['data'][1]['username'] . '">' . $post['likes']['data'][1]['full_name'] . '</a>';
                    if ($post['likes']['count'] > 2)
                        $userDetail['likes-block'] .= ' '. Yii::t('eauth', 'and') . ' <b>' . ($post['likes']['count'] - 2) . '</b> ' . Yii::t('eauth', 'others');
                }
                $userDetail['likes-block'] .= ' '.Yii::t('eauth', 'like this') . '.';
            }
            
            if (self::contentNeedSave($link))
            {
                if (!empty($userDetail['last_img']))
                {
                    $savedImg = self::saveImage($userDetail['last_img']);
                    if ($savedImg)
                        $userDetail['last_img'] = $savedImg;
                }
                $userDetail['soc_url'] = $link;
            }
        }
                
        return $userDetail;
    }
   
    public static function contentNeedSave($link)
    {
        $result = false;
        if (strpos($link, 'instagram.com') !== false && (strpos($link, '/p/') !== false) && strlen($link) > (strpos($link, '/p/') + strlen('/p/')))
            $result = true;

        return $result;
    }
   
    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['instagram_id']))
            $answer = true;
        
        return $answer;
    }
}