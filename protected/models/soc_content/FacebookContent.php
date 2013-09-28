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
        //привязана картинка
            if (isset(Yii::app()->user->id))
            {
                $socToken=SocToken::model()->findByAttributes(array(
                    'user_id'=>Yii::app()->user->id,
                    'type'=>1,
                ));
                
                if ($socToken)
                {
                    $userToken = $socToken->user_token;
                    
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
                    
                    $validation = self::makeRequest('https://graph.facebook.com/debug_token?input_token=' . $userToken . '&access_token=' . $appToken, array(), false);
                    $validation = CJSON::decode($validation, true);
                    if (isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true'))
                    {
                        $photoData = self::makeRequest('https://graph.facebook.com/' . $photoId . '?access_token=' . $userToken);
                        if (is_string($photoData) && (strpos($photoData, 'error:') !== false))
                            $userDetail['error'] = Yii::t('eauth', "You have no rights to use this post in your spot:") . $link;
                        elseif (!empty($photoData['id']) && !empty($photoData['source']) && !empty($photoData['images']))
                        {
                            $userDetail['last_img'] = $photoData['source'];
                            $savedImg = self::saveImage($userDetail['last_img']);
                            if ($savedImg)
                                $userDetail['last_img'] = $savedImg;
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
            //привязан пост или профиль
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
                //$appToken = Yii::app()->cache->get('facebookAppToken');
                $appToken = false;
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
                        /*
                        if (Yii::app()->cache->get('facebookAppToken') !== false)
                            Yii::app()->cache->delete('facebookAppToken');
                        Yii::app()->cache->set('facebookAppToken', $appToken);
                        */
                        $isAppTokenValid = true;
                    }
                }

                //привязан пост
                if (isset($postId) && isset($socUser['id']) && $isAppTokenValid)
                {
                    $socPost = self::makeRequest('https://graph.facebook.com/' . $socUser['id'] . '_' . $postId . '?access_token=' . $appToken);
                    if(is_string($socPost) && (strpos($socPost, 'error') !== false)){
                        $userDetail['error'] = Yii::t('eauth', "You have no rights to use this post in your spot:") . $link;
                    }elseif (isset($socPost['type']) && ($socPost['type'] == 'status') && isset($socPost['place']) && isset($socPost['place']['location']) && isset($socPost['place']['location']['latitude']) && isset($socPost['place']['location']['longitude']))
                    {
                        //"место" на карте
                        if (isset($socPost['story']))
                            $userDetail['sub-line'] = $socPost['story'];
                        if (isset($socPost['message']))
                            $userDetail['place_msg'] = $socPost['message'];
                        $userDetail['place_lat'] = $socPost['place']['location']['latitude'];
                        $userDetail['place_lng'] = $socPost['place']['location']['longitude'];
                        $userDetail['place_name'] = $socPost['place']['name'];
                    }
                    else
                    {
                        if (isset($socPost['story']))
                            $userDetail['sub-line'] = $socPost['story'];
                        elseif (isset($socPost['type']) 
                            and $socPost['type'] == 'link' 
                            and isset($socPost['status_type']) 
                            and $socPost['status_type'] == 'shared_story' 
                            and !empty($socPost['link']))
                                $userDetail['sub-line'] = Yii::t('eauth', 'shared a link');
                        if (!empty($socPost['picture']))
                        {
                            $userDetail['last_img'] = $socPost['picture'];
                            if (!empty($socPost['link']))
                                $userDetail['last_img_href'] = $socPost['link'];
                            if (!empty($socPost['message']))
                                $userDetail['last_img_msg'] = $socPost['message'];
                            elseif (!empty($socPost['story']))
                                $userDetail['last_img_msg'] = $socPost['story'];
                            if (!empty($socPost['name']) && ($socPost['name'] != 'Timeline Photos'))
                                $userDetail['last_img_story'] = '<p>'.$socPost['name'].'</p>';
                            else
                                $userDetail['last_img_story'] = '';
                            if (!empty($socPost['description']))
                                $userDetail['last_img_story'] .= '<p>'.$socPost['description'].'</p>';
                            if (!empty($socPost['caption']))
                                $userDetail['last_img_story'] .= '<p>'.$socPost['caption'].'</p>';
                            if ($userDetail['last_img_story'] == '')
                                unset($userDetail['last_img_story']);
                        }
                        elseif(!empty($socPost['link']) && (!empty($socPost['message']) || !empty($socPost['story'])))
                        {
                            $userDetail['link_href'] = $socPost['link'];
                            if (!empty($socPost['message']))
                                $userDetail['link_text'] = $socPost['message'];
                            elseif (!empty($socPost['story']))
                                $userDetail['link_text'] = $socPost['story'];
                        }
                        elseif (!empty($socPost['message']))
                            $userDetail['last_status'] = $socPost['message'];
                    }
                    if(empty($userDetail['last_status']) && empty($userDetail['last_img']) && empty($userDetail['place_name']) && empty($userDetail['error']))
                        $userDetail['error'] =  Yii::t('eauth', "This post doesn't exist:") . $link;
                }
                //последний пост из профиля
        
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

                            if (isset($userFeed['data']) 
                                && isset($userFeed['data'][$i]) 
                                && isset($userFeed['data'][$i]['from']) 
                                && isset($userFeed['data'][$i]['from']['id']) && ($userFeed['data'][$i]['from']['id'] == $socUser['id']) 
                                && (empty($userFeed['data'][$i]['status_type']) || ($userFeed['data'][$i]['status_type'] != 'approved_friend'))//не приглашение в друзья
                                && !(!empty($userFeed['data'][$i]['type']) 
                                    && !empty($userFeed['data'][$i]['story']) 
                                    && ($userFeed['data'][$i]['type'] == 'status') 
                                    && (strpos($userFeed['data'][$i]['story'], 'is now using Facebook in') !== false)
                                    )//не смена языка Facebook
                                && !(isset($userFeed['data'][$i]['type']) 
                                        && $userFeed['data'][$i]['type'] == 'status'
                                        && isset($userFeed['data'][$i]['privacy'])
                                        && isset($userFeed['data'][$i]['story'])
                                        && !isset($userFeed['data'][$i]['message'])
                                        && !isset($userFeed['data'][$i]['link'])
                                        && !isset($userFeed['data'][$i]['picture'])
                                        && !isset($userFeed['data'][$i]['icon'])
                                        && !isset($userFeed['data'][$i]['comments'])
                                    )//не комментарий от имени публичного профиля
                                )
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
                            if (isset($lastPost['story']))
                                $userDetail['sub-line'] = $lastPost['story'];
                            elseif (isset($lastPost['type']) 
                                and $lastPost['type'] == 'link' 
                                and isset($lastPost['status_type']) 
                                and $lastPost['status_type'] == 'shared_story' 
                                and !empty($lastPost['link']))
                                    $userDetail['sub-line'] = Yii::t('eauth', 'shared a link');
                            if (($lastPost['type'] == 'status') && isset($lastPost['place']) && isset($lastPost['place']['location']) && isset($lastPost['place']['location']['latitude']))
                            {
                                //"место" на карте
                                if (isset($lastPost['message']))
                                    $userDetail['place_msg'] = $lastPost['message'];
                                $userDetail['place_lat'] = $lastPost['place']['location']['latitude'];
                                $userDetail['place_lng'] = $lastPost['place']['location']['longitude'];
                                $userDetail['place_name'] = $lastPost['place']['name'];
                            }
                            else
                            {
                                if (!empty($lastPost['picture']))
                                {
                                    $userDetail['last_img'] = $lastPost['picture'];
                                    if (!empty($lastPost['link']))
                                    {
                                        $userDetail['last_img_href'] = $lastPost['link'];
                                        if (strpos($lastPost['link'], 'facebook.com/photo.php?fbid=') !== false)
                                        {
                                            $photoId = substr($lastPost['link'], (strpos($lastPost['link'], 'facebook.com/photo.php?fbid=') + 28));
                                            $photoId = self::rmGetParam($photoId);
                                            $photoData = self::makeRequest('https://graph.facebook.com/' . $photoId . '?access_token=' . $appToken);
                                        }
                                    }
                                    if (!empty($lastPost['message']))
                                        $userDetail['last_img_msg'] = $lastPost['message'];
                                    $userDetail['last_img_story'] = '';
                                    if (!empty($lastPost['description']))
                                        $userDetail['last_img_story'] .= '<p>'.$lastPost['description'].'</p>';
                                    if (!empty($lastPost['caption']))
                                        $userDetail['last_img_story'] .= '<p>'.$lastPost['caption'].'</p>';
                                    if ($userDetail['last_img_story'] == '')
                                        unset($userDetail['last_img_story']);
                                }
                                elseif(!empty($lastPost['link']) && (!empty($lastPost['message']) || !empty($lastPost['story'])))
                                {
                                    $userDetail['link_href'] = $lastPost['link'];
                                    if (!empty($lastPost['message']))
                                        $userDetail['link_text'] = $lastPost['message'];
                                }
                                elseif (!empty($lastPost['message']))
                                    $userDetail['last_status'] = $lastPost['message'];
                            }
                            
                            if (!empty($lastPost['created_time']))
                            {
                                $dateDiff = time() - strtotime($lastPost['created_time']);
                                $userDetail['footer-line'] = Yii::t('eauth', 'last post') . ' ';
                                if ($dateDiff > 86400)
                                    $userDetail['footer-line'] .= ((int)floor($dateDiff/86400)) . ' ' . Yii::t('eauth', 'days ago');
                                elseif ($dateDiff > 3600)
                                    $userDetail['footer-line'] .= ((int)floor($dateDiff/3600)) . ' ' . Yii::t('eauth', 'hours ago');
                                elseif ($dateDiff > 60)
                                    $userDetail['footer-line'] .= ((int)floor($dateDiff/60)) . ' ' . Yii::t('eauth', 'minutes ago');
                                else
                                    $userDetail['footer-line'] .= $dateDiff . ' ' . Yii::t('eauth', 'seconds ago');
                            }
                            
                        }
                        else
                        {
                            $query_url = 'https://graph.facebook.com/fql?q=SELECT+message+,+attachment+,created_time+FROM+stream+WHERE+source_id='
                            .$socUser['id']
                            .'+and+actor_id='
                            .$socUser['id']
                            .'+and+type+in+(46+,+80+,+128+,+247+,+237+,+272)LIMIT+1&access_token='
                            .$appToken;

                            if (@fopen($query_url, 'r'))
                            {
                                $fql_query_result = file_get_contents($query_url);
                                $lastPost = json_decode($fql_query_result, true);

                                if(isset($lastPost['data']) && isset($lastPost['data'][0])){
                                    $lastPost = $lastPost['data'][0];

                                if (isset($lastPost['story']))
                                    $userDetail['sub-line'] = $lastPost['story'];
                                elseif (isset($lastPost['type']) 
                                    and $lastPost['type'] == 'link' 
                                    and isset($lastPost['status_type']) 
                                    and $lastPost['status_type'] == 'shared_story' 
                                    and !empty($lastPost['link']))
                                        $userDetail['sub-line'] = Yii::t('eauth', 'shared a link');
                                
                                    if (isset($lastPost['attachment']) and isset($lastPost['attachment']['media']) and isset($lastPost['attachment']['media'][0]) and isset($lastPost['attachment']['media'][0]['href']) and (strpos($lastPost['attachment']['media'][0]['href'], 'facebook.com/photo.php?fbid=') !== false))
                                    {
                                        $photoId = substr($lastPost['attachment']['media'][0]['href'], (strpos($lastPost['attachment']['media'][0]['href'], 'facebook.com/photo.php?fbid=') + 28));
                                        $photoId = self::rmGetParam($photoId);
                                    
                                        $photoData = self::makeRequest('https://graph.facebook.com/' . $photoId . '?access_token=' . $appToken);
                                    }
                                    elseif(!empty($lastPost['message']))
                                        $userDetail['last_status'] = $lastPost['message'];
                                  
                                    unset($dateDiff);
                                    
                                    if (!empty($lastPost['created_time']))
                                    {
                                        $dateDiff = time() - $lastPost['created_time'];
                                        $userDetail['footer-line'] = Yii::t('eauth', 'last post') . ' ';
                                        if ($dateDiff > 86400)
                                            $userDetail['footer-line'] .= ((int)floor($dateDiff/86400)) . ' ' . Yii::t('eauth', 'days ago');
                                        elseif ($dateDiff > 3600)
                                            $userDetail['footer-line'] .= ((int)floor($dateDiff/3600)) . ' ' . Yii::t('eauth', 'hours ago');
                                        elseif ($dateDiff > 60)
                                            $userDetail['footer-line'] .= ((int)floor($dateDiff/60)) . ' ' . Yii::t('eauth', 'minutes ago');
                                        else
                                            $userDetail['footer-line'] .= $dateDiff . ' ' . Yii::t('eauth', 'seconds ago');
                                    }
                                }
                            }
                        }

                        if (isset($photoData) && !(is_string($photoData) && (strpos($photoData, 'error:') !== false)) && isset($photoData) && !empty($photoData['id']) && !empty($photoData['source']) && !empty($photoData['images']))
                        {
                            $userDetail['last_img'] = $photoData['source'];
                            if (!empty($photoData['name']))
                                $userDetail['last_img_msg'] = $photoData['name'];
                            if (!empty($photoData['link']))
                                $userDetail['last_img_href'] = $photoData['link'];
                        }
                    }
                }
            }else
            {
                $userDetail['error'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
        }
  
        if (!empty($userDetail['sub-line'])
            and !empty($userDetail['soc_username']) 
            and strpos($userDetail['sub-line'],$userDetail['soc_username']) !== false
            and strpos($userDetail['sub-line'],$userDetail['soc_username']) == 0)
                $userDetail['sub-line'] = substr($userDetail['sub-line'], 
                                                (strpos($userDetail['sub-line'], $userDetail['soc_username']) + strlen($userDetail['soc_username']))
                );
  
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

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['facebook_id']))
        {
            if (isset(Yii::app()->user->id))
            {
                $socToken=SocToken::model()->findByAttributes(array(
                    'user_id'=>Yii::app()->user->id,
                    'type'=>1,
                ));
                
                if ($socToken && ($socToken->token_expires - Time()) > 60)
                {
                    $answer = true;
                /*
                    if (($socToken->token_expires - Time()) < 60)
                    {
                        $userToken = $socToken->user_token;
                        
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
                        
                        $validation = self::makeRequest('https://graph.facebook.com/debug_token?input_token=' . $userToken . '&access_token=' . $appToken, array(), false);
                        $validation = CJSON::decode($validation, true);
                        if (isset($validation['data']) and isset($validation['data']['is_valid']) and ($validation['data']['is_valid'] == 'true'))
                        {
                            $answer = true;
                        }
                    }
                */
                }
            }
        }
        
        return $answer;
    }
}