<?php

class FacebookContent extends SocContentBase
{

    const API_PATH = 'https://graph.facebook.com/';
    const FQL_PATH = 'https://graph.facebook.com/fql?q=';

    const URL_BASE = 'facebook.com/';
    const URL_PHOTO = '/photo.php?fbid=';
    const URL_POSTS = '/posts/';
    const URL_MY_LIKES = 'me/likes/';
    
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
        $userDetail['block_type'] = self::TYPE_POST;
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
                $socToken = SocToken::model()->findByAttributes(array(
                    'user_id' => Yii::app()->user->id,
                    'type' => 1,
                ));

                if ($socToken)
                {
                    $userToken = $socToken->user_token;

                    $appToken = self::getAppToken();

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
                                if (empty($photoData['from']['category']))
                                {
                                    $redirectUrl = '';
                                    $spot = Spot::model()->findByPk($discodesId);
                                    if ($spot)
                                        $redirectUrl = '&redirect_uri=' . urlencode('http://m.mobispot.com/' . $spot->url);
                                    $userDetail['follow_url'] = 'https://www.facebook.com/dialog/friends/?id=' . $photoData['from']['id']
                                            . '&app_id=' . Yii::app()->eauth->services['facebook_mobile']['client_id']
                                            . $redirectUrl;
                                }
                            }
                        }
                        else
                            $userDetail['error'] = Yii::t('eauth', "This post doesn't exist:") . $link;
                    }
                    else
                        $userDetail['error'] = 'User not logged in';
                }
            }
            if (empty($userDetail['last_img']) && empty($userDetail['error']))
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

                $redirectUrl = '';
                $spot = Spot::model()->findByPk($discodesId);
                if ($spot)
                    $redirectUrl = '&redirect_uri=' . urlencode('http://m.mobispot.com/' . $spot->url);
                if (empty($socUser['category']))
                    $userDetail['follow_url'] = 'https://www.facebook.com/dialog/friends/?id=' . $socUser['id']
                            . '&app_id=' . Yii::app()->eauth->services['facebook_mobile']['client_id']
                            . $redirectUrl;

                $appToken = self::getAppToken();

                //привязан пост
                if (isset($postId) && isset($socUser['id']) && !empty($appToken))
                {
                    $socToken = SocToken::model()->findByAttributes(array(
                        'user_id' => Yii::app()->user->id,
                        'type' => 1,
                    ));
                    
                    if ($socToken)
                        $userToken = $socToken->user_token;
                    else
                        $userToken = false;
                
                    $socPost = self::makeRequest('https://graph.facebook.com/' . $socUser['id'] . '_' . $postId . '?access_token=' . $userToken);
                    if (is_string($socPost) && (strpos($socPost, 'error') !== false))
                    {
                        $userDetail['error'] = Yii::t('eauth', "You have no rights to use this post in your spot:") . $link;
                    }
                    else
                    {
                        $postContent = self::getPostContent($socPost);
                        foreach ($postContent as $postKey => $postValue)
                            $userDetail[$postKey] = $postValue;
                    }

                    if (empty($userDetail['last_status']) && empty($userDetail['last_img']) && empty($userDetail['place_name']) && empty($userDetail['error']) && empty($userDetail['link_text']))
                        $userDetail['error'] = Yii::t('eauth', "This post doesn't exist:") . $link;
                }
                //последний пост из профиля

                elseif (!empty($appToken))
                {
                    $userFeed = self::makeRequest('https://graph.facebook.com/' . $socUsername . '/feed?access_token=' . $appToken);

                    unset($lastPost);
                    $i = 0;
                    $prevPageUrl = '';

                    if (isset($socUser['id']))
                    {
                        while (!isset($lastPost))
                        {

                            if (isset($userFeed['data']) && isset($userFeed['data'][$i]) && isset($userFeed['data'][$i]['from']) && isset($userFeed['data'][$i]['from']['id']) && ($userFeed['data'][$i]['from']['id'] == $socUser['id']) && (empty($userFeed['data'][$i]['status_type']) || ($userFeed['data'][$i]['status_type'] != 'approved_friend'))//не приглашение в друзья
                                    && !(!empty($userFeed['data'][$i]['type']) && !empty($userFeed['data'][$i]['story']) && ($userFeed['data'][$i]['type'] == 'status') && (strpos($userFeed['data'][$i]['story'], 'is now using Facebook in') !== false)
                                    )//не смена языка Facebook
                                    && !(isset($userFeed['data'][$i]['type']) && $userFeed['data'][$i]['type'] == 'status' && isset($userFeed['data'][$i]['privacy']) && isset($userFeed['data'][$i]['story']) && !isset($userFeed['data'][$i]['message']) && !isset($userFeed['data'][$i]['link']) && !isset($userFeed['data'][$i]['picture']) && !isset($userFeed['data'][$i]['icon']) && !isset($userFeed['data'][$i]['comments'])
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
                            $postContent = self::getPostContent($lastPost);
                            foreach ($postContent as $postKey => $postValue)
                                $userDetail[$postKey] = $postValue;
                        }
                        else
                        {
                            $query_url = 'https://graph.facebook.com/fql?q=SELECT+message+,+attachment+,created_time+FROM+stream+WHERE+source_id='
                                    . $socUser['id']
                                    . '+and+actor_id='
                                    . $socUser['id']
                                    . '+and+type+in+(46+,+80+,+128+,+247+,+237+,+272)LIMIT+1&access_token='
                                    . $appToken;

                            if (@fopen($query_url, 'r'))
                            {
                                $fql_query_result = file_get_contents($query_url);
                                $lastPost = json_decode($fql_query_result, true);

                                if (isset($lastPost['data']) && isset($lastPost['data'][0]))
                                {
                                    $lastPost = $lastPost['data'][0];

                                    if (isset($lastPost['story']))
                                        $userDetail['sub-line'] = $lastPost['story'];
                                    elseif (isset($lastPost['type']) and $lastPost['type'] == 'link' and isset($lastPost['status_type']) and $lastPost['status_type'] == 'shared_story' and !empty($lastPost['link']))
                                    {
                                        //$userDetail['block_type'] = self::TYPE_SHARED_LINK;
                                        $userDetail['sub-line'] = Yii::t('eauth', 'shared a link');
                                        
                                    }

                                    if (isset($lastPost['attachment']) and isset($lastPost['attachment']['media']) and isset($lastPost['attachment']['media'][0]) and isset($lastPost['attachment']['media'][0]['href']) and (strpos($lastPost['attachment']['media'][0]['href'], 'facebook.com/photo.php?fbid=') !== false))
                                    {
                                        $photoId = substr($lastPost['attachment']['media'][0]['href'], (strpos($lastPost['attachment']['media'][0]['href'], 'facebook.com/photo.php?fbid=') + 28));
                                        $photoId = self::rmGetParam($photoId);

                                        $photoData = self::makeRequest('https://graph.facebook.com/' . $photoId . '?access_token=' . $appToken);
                                    }
                                    elseif (!empty($lastPost['message']))
                                        $userDetail['last_status'] = $lastPost['message'];

                                    unset($dateDiff);

                                    if (!empty($lastPost['created_time']))
                                    {
                                        $dateDiff = time() - $lastPost['created_time'];
                                        $userDetail['footer-line'] = Yii::t('eauth', 'last post') . ' ' . SocContentBase::timeDiff($dateDiff);
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

        if (!empty($userDetail['sub-line']) and !empty($userDetail['soc_username']) and strpos($userDetail['sub-line'], $userDetail['soc_username']) !== false and strpos($userDetail['sub-line'], $userDetail['soc_username']) == 0)
            $userDetail['sub-line'] = substr($userDetail['sub-line'], (strpos($userDetail['sub-line'], $userDetail['soc_username']) + strlen($userDetail['soc_username']))
            );

        if (self::contentNeedSave($link))
        {
            if (!empty($userDetail['last_img']))
            {
                $savedImg = self::saveImage($userDetail['last_img']);
                if ($savedImg)
                    $userDetail['last_img'] = $savedImg;
            }

            if (!empty($userDetail['footer-line']))
            {
                $userDetail['footer-line'] = str_replace(Yii::t('eauth', 'last post'), '', $userDetail['footer-line']);
            }
            $userDetail['soc_url'] = $link;
        }
        
        $userDetail['text'] = '';
        if (!empty($userDetail['last_status']))
            $userDetail['text'] .= $userDetail['last_status'].' ';
        if (!empty($userDetail['last_img_msg']))
            $userDetail['text'] .= $userDetail['last_img_msg'].' ';
        if (!empty($userDetail['last_img_story']))
            $userDetail['text'] .= $userDetail['last_img_story'].' ';

        return $userDetail;
    }

    public static function getPostContent($post, $appToken = null)
    {

        $postContent = array();

        if (!empty($post['story']))
            $postContent['sub-line'] = $post['story'];

        if (($post['type'] == 'status') && isset($post['place']) && isset($post['place']['location']) && isset($post['place']['location']['latitude']))
        {
            //"место" на карте
            if (isset($post['message']))
                $postContent['place_msg'] = $post['message'];
            $postContent['place_lat'] = $post['place']['location']['latitude'];
            $postContent['place_lng'] = $post['place']['location']['longitude'];
            $postContent['place_name'] = $post['place']['name'];
        }
        else
        {
            if (isset($post['type']) and in_array($post['type'], array("link", "video")) and isset($post['status_type']) and $post['status_type'] == 'shared_story' and !empty($post['link']))
            {
                //разшаренная ссылка
                $postContent['shared_link'] = $post['link'];
                $postContent['block_type'] = self::TYPE_SHARED_LINK;
                if (!empty($post['name']))
                    $postContent['link_name'] = $post['name'];
                if (!empty($post['caption']))
                    $postContent['link_caption'] = $post['caption'];
                if (!empty($post['description']))
                    $postContent['link_description'] = $post['description'];
                if (empty($socPost['story']))
                    $postContent['sub-line'] = Yii::t('eauth', 'shared a link');

                if ((strpos($post['link'], 'youtube.com') !== false) && (strpos($post['link'], 'watch?v=') !== false))
                {
                    $videoContent = YouTubeContent::getVideoContent($post['link']);

                    if (empty($videoContent['error']))
                    {
                        foreach ($videoContent as $vKey => $vValue)
                            $postContent[$vKey] = $vValue;
                    }
                }
            }
            if (!empty($post['picture']))
            {
                $postContent['last_img'] = $post['picture'];
                if (!empty($post['link']))
                {
                    if (empty($appToken))
                        $appToken = self::getAppToken();
                    $postContent['last_img_href'] = $post['link'];
                    if (strpos($post['link'], 'facebook.com/photo.php?fbid=') !== false and !empty($appToken))
                    {
                        $photoId = substr($post['link'], (strpos($post['link'], 'facebook.com/photo.php?fbid=') + 28));
                        $photoId = self::rmGetParam($photoId);
                        $photoData = self::makeRequest('https://graph.facebook.com/' . $photoId . '?access_token=' . $appToken);
                    }
                }
                if (!empty($post['message']))
                    $postContent['last_img_msg'] = $post['message'];
                $postContent['last_img_story'] = '';
                if (!empty($post['description']) && empty($postContent['link_description']))
                    $postContent['last_img_story'] .= '<p>' . $post['description'] . '</p>';
                if ($postContent['last_img_story'] == '')
                    unset($postContent['last_img_story']);
            }
            elseif (!empty($post['link']) && (!empty($post['message']) || !empty($post['story'])))
            {
                $postContent['link_href'] = $post['link'];
                if (!empty($post['message']))
                    $postContent['link_text'] = $post['message'];
            }
            elseif (!empty($post['message']))
                $postContent['last_status'] = $post['message'];
        }

        if (!empty($post['created_time']))
        {
            $dateDiff = time() - strtotime($post['created_time']);
            $postContent['footer-line'] = Yii::t('eauth', 'last post') . ' ' . SocContentBase::timeDiff($dateDiff);
        }

        return $postContent;

        //var_dump($postContent);
    }

    public static function getAppToken()
    {
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
                //$isAppTokenValid = true;
            }
        }

        return $appToken;
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
        if ((strpos($link, 'facebook.com/') !== false) and (strpos($link, '/posts/') !== false))
            $result = true;
        elseif (strpos($link, 'facebook.com/photo.php?fbid=') !== false)
            $result = true;
        return $result;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (empty(Yii::app()->session['facebook_id']))
            return $answer;
        
        if (!isset(Yii::app()->user->id))
            return $answer;
            
        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => 1,
        ));

        if ($socToken and ($socToken->token_expires - Time()) > 60)
            $answer = true;
        
        return $answer;
    }

    public static function checkSharing($sharing_type, $link)
    {
        $answer = false;
        
        switch($sharing_type) {
            case Loyalty::FACEBOOK_LIKE: 
                $answer = self::checkLike($link);
            break;
            case Loyalty::FACEBOOK_SHARE: 
                $answer = self::checkLinkSharing($link);
            break;
        }
        
        return $answer;
    }
    
    public static function checkLike($link)
    {
        $liked = false;
        $object_id = 0;
        
        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocToken::TYPE_FACEBOOK,
        ));
        
        if (!$socToken)
            return false;

        if (strpos($link, self::URL_BASE) !== false
            and
            (
                strpos($link, self::URL_PHOTO) !== false
                or
                strpos($link, self::URL_POSTS) !== false
            )
        )
        {
            if (strpos($link, self::URL_POSTS) !== false)
                // пост
                $object_id = self::parseParam($link, self::URL_POSTS);
            else
                // фото
                $object_id = self::parseParam($link, self::URL_PHOTO);
                
            $query = 'SELECT object_id,user_id FROM like WHERE user_id = me() and object_id = ' . $object_id;
            
            $like = self::makeRequest(
                self::FQL_PATH 
                . str_replace(' ', '+', $query) 
                . '&access_token=' . $socToken->user_token
            );
            
            if (isset($like['data']) 
                and isset($like['data'][0])
                and isset($like['data'][0]['object_id'])
                and $like['data'][0]['object_id'] == $object_id
            )
                $liked = true;
        }
        elseif (strpos($link, self::URL_BASE))
        {
            $username = self::parseUsername($link);
            
            //сначала получаем $page['id']
            $page = self::makeRequest(
                self::API_PATH 
                . $username
                . '?access_token=' . $socToken->user_token
            );

            if (!empty($page['id']))
            {
                $like = self::makeRequest(
                    self::API_PATH
                    . self::URL_MY_LIKES
                    . $page['id']
                    . '?access_token=' . $socToken->user_token
                );

                if (isset($like['data']) 
                    and isset($like['data'][0]) 
                    and !empty($like['data'][0]['id'])
                )
                    $liked = true;
            }
        }
        else
        {
            // like внешней ссылки
            $query = 'SELECT attachment ,created_time ,type ,description FROM stream WHERE source_id=me() and strpos(attachment.href,"'. $link. '")>=0 and strpos(attachment.href,"fb_action_types=og.likes") > 0';

            $like = self::makeRequest(
                self::FQL_PATH
                . str_replace(' ', '+', $query)
                . '&access_token=' . $socToken->user_token
            );
            
            if (isset($like['data']) 
                and isset($like['data'][0])
                and isset($like['data'][0]['attachment'])
                and !empty($like['data'][0]['attachment']['href'])
            )
                $liked = true;
        }
                
        return $liked;
    }
    
    public static function checkLinkSharing($link)
    {
        $shared = false;

        $socToken = SocToken::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => SocToken::TYPE_FACEBOOK,
        ));
        
        if (!$socToken)
            return false;
        
        $query = 'SELECT attachment ,created_time ,type ,description FROM stream WHERE source_id=me() and actor_id=me() and type=80 and attachment.href="'.$link.'"';

        $sharing = self::makeRequest(
                self::FQL_PATH
                . str_replace(' ', '+', $query)
                . '&access_token=' . $socToken->user_token
        );

        if (isset($sharing['data']) 
            and isset($sharing['data'][0])
            and isset($sharing['data'][0]['attachment'])
            and !empty($sharing['data'][0]['attachment']['href'])
        )
            $shared = true;
    
        return $shared;
    }
}
