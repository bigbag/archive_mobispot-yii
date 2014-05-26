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
        $userDetail['block_type'] = self::INSTAGRAM_PHOTO;
        unset($post);
        $needSave = self::contentNeedSave($link);
        

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
/*
                $techSoc = SocToken::model()->findByAttributes(array(
                    'type' => 10,
                    'is_tech' => true
                ));
*/
                if (isset($socUser['id']))
                {
                    $media = self::makeRequest('https://api.instagram.com/v1/users/' . $socUser['id'] . '/media/recent?count=1&client_id=' . Yii::app()->eauth->services['instagram']['client_id']);
                    if (isset($media['data']) && isset($media['data'][0]) && !empty($media['data'][0]['id']))
                        $post = $media['data'][0];
                }
            }
            else
                $userDetail['error'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            //    $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }

        if (isset($post))
        {
            if (!empty($post['user']['profile_picture']))
                $userDetail['photo'] = $post['user']['profile_picture'];
            if (!empty($post['user']['full_name']))
                $userDetail['soc_username'] = $post['user']['full_name'];
            elseif (!empty($post['user']['username']))
                $userDetail['soc_username'] = $post['user']['username'];
            if (!empty(Yii::app()->session['instagram_mobile_follow_' . $post['user']['id']]) && !$needSave)
            {
                $userDetail['invite'] = Yii::t('eauth', 'You\'re following ') . $userDetail['soc_username'];
            }
            else
            {
                $userDetail['follow_service'] = 'instagram_mobile';
                $userDetail['follow_param'] = $post['user']['id'];
            }

            if ($needSave)
            {
                $userDetail['check_following'] = 'instagram_mobile_follow_' . $post['user']['id'];
                $userDetail['message_following'] = Yii::t('eauth', 'You\'re following ') . $userDetail['soc_username'];
            }

            if (isset($post['location']) && !empty($post['location']['name']))
                $userDetail['sub-line'] = $post['location']['name'];
            if (!empty($post['created_time']))
            {
                $dateDiff = time() - (int) $post['created_time'];
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
                        $userDetail['likes-block'] .= ' ' . Yii::t('eauth', 'and') . ' ';
                    $userDetail['likes-block'] .= '<a class="authot-name" href="http://instagram.com/' . $post['likes']['data'][1]['username'] . '">' . $post['likes']['data'][1]['full_name'] . '</a>';
                    if ($post['likes']['count'] > 2)
                        $userDetail['likes-block'] .= ' ' . Yii::t('eauth', 'and') . ' <b>' . ($post['likes']['count'] - 2) . '</b> ' . Yii::t('eauth', 'others');
                }
                $userDetail['likes-block'] .= ' ' . Yii::t('eauth', 'like this') . '.';
            }

            if ($needSave)
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
        
        $userDetail['text'] = self::clueImgText($userDetail);

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
        if (!empty(Yii::app()->session['instagram_token']))
            $answer = true;

        return $answer;
    }

    public static function followSocial($idUser)
    {
        $answer = array();
        $answer['error'] = 'yes';
        if (!empty($idUser) && !empty(Yii::app()->session['instagram_token']))
        {

            $followResult = self::makeRequest('https://api.instagram.com/v1/users/' . $idUser
                            . '/relationship?access_token=' . Yii::app()->session['instagram_token']
                            . '&action=follow'
                            , array('data' => 'access_token=' . Yii::app()->session['instagram_token'] . '&action=follow'));

            if (isset($followResult['data']) && isset($followResult['data']['outgoing_status']))
            {
                $answer['error'] = 'no';
                $user = self::makeRequest('https://api.instagram.com/v1/users/' . $idUser . '/?access_token=' . Yii::app()->session['instagram_token']);
                if (isset($user['data']))
                {
                    $userName = '';
                    if (!empty($user['data']['full_name']))
                        $userName = $user['data']['full_name'];
                    elseif (!empty($user['data']['username']))
                        $userName = $user['data']['username'];
                    $answer['message'] = Yii::t('eauth', 'You\'re following ') . $userName;
                }
            }
        }

        return $answer;
    }

}
