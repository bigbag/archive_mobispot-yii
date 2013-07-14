<?php

class FacebookContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';
        unset($postId);
        
        if ((strpos($link, 'facebook.com/') !== false) && (strpos($link, '/posts/') !== false))
        {
            $postId = substr($link, (strpos($link, '/posts/') + 7));
            $postId = self::rmGetParam($postId);
        }
        
        if (strpos($link, 'facebook.com/photo.php?fbid=') === false)
        {
            $socUsername = self::parseUsername($link);
            $result = 'ok';
            $socUser = self::makeRequest('https://graph.facebook.com/' . $socUsername);

            if (!empty($socUser['error']) || empty($socUser['id']))
                $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            elseif ((empty($socUser['is_published']) || ($socUser['is_published'] != 'true')) && !isset($postId))
            {
                if (empty(Yii::app()->session['facebook_id']))
                {
                    $result = Yii::t('eauth', "Please log in with your Facebook account to perform this action");
                }
                elseif (Yii::app()->session['facebook_id'] != $socUser['id'])
                {
                    $result = Yii::t('eauth', "You are not allowed to use page of another person in your spot");
                }
            }
        }
        
        return $result;
    }
    
    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        unset($postId);
        unset($photoId);
        
        if (strpos($link, 'facebook.com/photo.php?fbid=') !== false)
        {
            $photoId = substr($link, (strpos($link, 'facebook.com/photo.php?fbid=') + 28));
            $photoId = self::rmGetParam($photoId);
        }
        elseif ((strpos($link, 'facebook.com/') !== false) && (strpos($link, '/posts/') !== false))
        {
            $postId = substr($link, (strpos($link, '/posts/') + 7));
            $postId = self::rmGetParam($postId);
        }

        if (!empty($photoId))
        {
            if (isset(Yii::app()->user->id))
            {
                $socToken=SocToken::model()->findByAttributes(array(
                    'user_id'=>Yii::app()->user->id,
                    'type'=>1,
                ));
                
                if ($socToken)
                {
                    $userToken = $socToken->user_token;
                    
                    $validation = self::makeRequest('https://graph.facebook.com/debug_token?input_token=' . $userToken . '&access_token=' . $userToken, array(), false);
                    $validation = CJSON::decode($validation, true);
                    if (isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true'))
                    {
                        $photoData = self::makeRequest('https://graph.facebook.com/' . $photoId . '?access_token=' . $userToken);
                        if (is_string($photoData) && (strpos($photoData, 'error:') !== false))
                            $userDetail['error'] = Yii::t('eauth', "You have no rights to use this post in your spot:") . $link;
                        elseif (!empty($photoData['id']) && !empty($photoData['source']) && !empty($photoData['images']))
                        {
                            $userDetail['last_img'] = $photoData['source'];
                            if (!empty($photoData['name']))
                                $userDetail['last_img_msg'] = $photoData['name'];
                            if (!empty($photoData['link']))
                                $userDetail['last_img_href'] = $photoData['link'];

                            if (isset($photoData['from']) && !empty($photoData['from']['id']))
                            {
                                $socUser = self::makeRequest('https://graph.facebook.com/' . $photoData['from']['id']);
                                $userDetail['photo'] = 'http://graph.facebook.com/' . $photoData['from']['id'] . '/picture';
                                if (isset($socUser['name']))
                                    $userDetail['soc_username'] = $socUser['name'];
                                if (!empty($socUser['first_name']) && !empty($socUser['last_name']))
                                    $userDetail['soc_username'] = $socUser['first_name'] . ' ' . $socUser['last_name'];
                                if (isset($socUser['link']))
                                    $userDetail['soc_url'] = $socUser['link'];
                                else
                                    $userDetail['soc_url'] = 'https://www.facebook.com/' . $photoData['from']['id'];
                            }
                        }
                        else
                            $userDetail['error'] =  Yii::t('eauth', "This post doesn't exist:") . $link;
                    }
                    else
                        $userDetail['error'] = 'User not logged in';
                }
            }
            if(empty($userDetail['last_img']) && empty($userDetail['error']))
                $userDetail['error'] = Yii::t('eauth', "You have no rights to use this post in your spot:") . $link;
        }
        else
        {
            $socUsername = self::parseUsername($link);
            $socUser = self::makeRequest('https://graph.facebook.com/' . $socUsername);

            if (!isset($socUser['error']) && isset($socUser['id']))
            {
                $userDetail['UserExists'] = true;
                //$userDetail['soc_id'] = $socUser['id'];
                $userDetail['photo'] = 'http://graph.facebook.com/' . $socUsername . '/picture';
                if (isset($socUser['name']))
                    $userDetail['soc_username'] = $socUser['name'];
                if (!empty($socUser['first_name']) && !empty($socUser['last_name']))
                    $userDetail['soc_username'] = $socUser['first_name'] . ' ' . $socUser['last_name'];
                if (isset($socUser['link']))
                    $userDetail['soc_url'] = $socUser['link'];
                else
                    $userDetail['soc_url'] = 'https://www.facebook.com/' . $socUsername;
/*
                if (isset($socUser['gender']))
                    $userDetail['gender'] = $socUser['gender'];
                if (isset($socUser['locale']))
                    $userDetail['locale'] = $socUser['locale'];
*/
                //жетон приложения
                $appToken = Yii::app()->cache->get('facebookAppToken');
                $isAppTokenValid = false;

                if ($appToken !== false)
                {
                    $validation = self::makeRequest('https://graph.facebook.com/debug_token?input_token=' . $appToken . '&access_token=' . $appToken, array(), false);
                    $validation = CJSON::decode($validation, true);
                    if (isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true'))
                        $isAppTokenValid = true;
                }

                if (!$isAppTokenValid)
                {
                    if (@fopen('https://graph.facebook.com/oauth/access_token?client_id=' . Yii::app()->eauth->services['facebook']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['facebook']['client_secret'] . '&grant_type=client_credentials', 'r'))
                    {
                        $textToken = fopen('https://graph.facebook.com/oauth/access_token?client_id=' . Yii::app()->eauth->services['facebook']['client_id'] . '&client_secret=' . Yii::app()->eauth->services['facebook']['client_secret'] . '&grant_type=client_credentials', 'r');
                        $appToken = fgets($textToken);
                        fclose($textToken);
                        if ((strpos($appToken, 'access_token=') > 0) || (strpos($appToken, 'access_token=') !== false))
                            $appToken = substr($appToken, (strpos($appToken, 'access_token=') + 13));
                        Yii::app()->cache->set('facebookAppToken', $appToken);
                        $isAppTokenValid = true;
                    }
                }
                
                
                //привязан пост
                if (isset($postId) && isset($socUser['id']) && $isAppTokenValid)
                {
                    $socPost = self::makeRequest('https://graph.facebook.com/' . $socUser['id'] . '_' . $postId . '?access_token=' . $appToken);
                    if(is_string($socPost) && (strpos($socPost, 'error') !== false)){
                        $userDetail['error'] = Yii::t('eauth', "You have no rights to use this post in your spot:") . $link;
                    }elseif (isset($socPost['type']) && ($socPost['type'] == 'photo') && isset($socPost['picture']))
                    {
                        $userDetail['last_img'] = $socPost['picture'];
                        if (isset($socPost['message']))
                            $userDetail['last_img_msg'] = $socPost['message'];
                        if (isset($socPost['story']))
                            $userDetail['last_img_story'] = $socPost['story'];
                    }
                    elseif (($socPost['type'] == 'status') && isset($socPost['place']) && isset($socPost['place']['location']) && isset($socPost['place']['location']['latitude']) && isset($socPost['place']['location']['longitude']) && isset($socPost['place']['name']))
                    {
                        //"место" на карте
                        if (isset($socPost['message']))
                            $userDetail['place_msg'] = $socPost['message'];
                        $userDetail['place_lat'] = $socPost['place']['location']['latitude'];
                        $userDetail['place_lng'] = $socPost['place']['location']['longitude'];
                        $userDetail['place_name'] = $socPost['place']['name'];
                    }else
                    {
                        if (isset($socPost['message']))
                            $userDetail['last_status'] = $socPost['message'];
                        elseif (isset($socPost['story']))
                            $userDetail['last_status'] = $socPost['story'];
                    }
                    if(empty($userDetail['last_status']) && empty($userDetail['last_img']) && empty($userDetail['place_name']) && empty($userDetail['error']))
                        $userDetail['error'] =  Yii::t('eauth', "This post doesn't exist:") . $link;
                }
                //последний пост
        
                elseif (!empty($appToken) && $isAppTokenValid)
                {
                    $userFeed = self::makeRequest('https://graph.facebook.com/' . $socUsername . '/feed?access_token=' . $appToken);

                    unset($lastPost);
                    $i = 0;
                    $prevPageUrl = '';

                    if (isset($socUser['id']))
                    {
                        while (!isset($lastPost))
                        {

                            if (isset($userFeed['data']) && isset($userFeed['data'][$i]) && isset($userFeed['data'][$i]['from']) && isset($userFeed['data'][$i]['from']['id']) && ($userFeed['data'][$i]['from']['id'] == $socUser['id']) /*&& !isset($userFeed['data'][$i]['application'])*/)
                            {
                                $lastPost = $userFeed['data'][$i];
                            }
                            //следующая страница
                            elseif (!isset($userFeed['data']) || ($i >= count($userFeed['data'])) || (!isset($userFeed['data'][$i])))
                            {
                                if (isset($userFeed['paging']) && isset($userFeed['paging']['previous']) && ($userFeed['paging']['previous'] != $prevPageUrl))
                                {
                                    $prevPageUrl = $userFeed['paging']['previous'];
                                    $userFeed = self::makeRequest($userFeed['paging']['previous'] . '&access_token=' . $appToken);
                                    $i = 0;
                                }
                                else
                                {
                                    $lastPost = 'no';
                                }
                            }
                            else
                            {
                                $i++;
                            }
                        }

                        if ($lastPost != 'no')
                        {
                            if ($lastPost['type'] == 'photo')
                            {
                                $userDetail['last_img'] = $lastPost['picture'];
                                if (isset($lastPost['message']))
                                    $userDetail['last_img_msg'] = $lastPost['message'];
                                if (isset($lastPost['story']))
                                    $userDetail['last_img_story'] = $lastPost['story'];
                            }elseif (($lastPost['type'] == 'status') && isset($lastPost['place']) && isset($lastPost['place']['location']) && isset($lastPost['place']['location']['latitude']))
                            {
                                //"место" на карте
                                if (isset($lastPost['message']))
                                    $userDetail['place_msg'] = $lastPost['message'];
                                $userDetail['place_lat'] = $lastPost['place']['location']['latitude'];
                                $userDetail['place_lng'] = $lastPost['place']['location']['longitude'];
                                $userDetail['place_name'] = $lastPost['place']['name'];
                            }else
                            {
                                if (isset($lastPost['message']))
                                    $userDetail['last_status'] = $lastPost['message'];
                                elseif (isset($lastPost['story']))
                                    $userDetail['last_status'] = $lastPost['story'];
                            }
                        }
                    }
                }
            }else
            {
                $userDetail['error'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
        }
        
        return $userDetail;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'facebook.com/') !== false)
        {
            $username = substr($username, (strpos($username, 'facebook.com/') + 13));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function contentNeedSave($link)
    {
        $result = false;
        if ((strpos($link, 'facebook.com/') !== false) && (strpos($link, '/posts/') !== false))
            $result = true;
        elseif (strpos($link, 'facebook.com/photo.php?fbid=') !== false)
            $result = true;
        return $result;
    }

}