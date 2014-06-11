<?php

class GoogleContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $socUser = self::makeRequest('https://www.googleapis.com/plus/v1/people/' . $socUsername . '?key=' . Yii::app()->eauth->services['google_oauth']['key']);
        if (empty($socUser['id']) || !empty($socUser['error']) || !empty($socUser['errors']))
            $result = Yii::t('social', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);
        $userDetail['block_type'] = self::TYPE_POST;

        $socUser = self::makeRequest('https://www.googleapis.com/plus/v1/people/' . $socUsername . '?key=' . Yii::app()->eauth->services['google_oauth']['key']);

        if (!isset($socUser['error']) && !isset($socUser['errors']) && isset($socUser['id'])) {
            $userDetail['UserExists'] = true;
            if (isset($socUser['displayName']))
                $userDetail['soc_username'] = $socUser['displayName'];
            if (isset($socUser['image']) && isset($socUser['image']['url']))
                $userDetail['photo'] = $socUser['image']['url'];
            if (isset($socUser['name']) && isset($socUser['name']['givenName']))
                $userDetail['first_name'] = $socUser['name']['givenName'];
            if (isset($socUser['name']) && isset($socUser['name']['familyName']))
                $userDetail['last_name'] = $socUser['name']['familyName'];
            $userDetail['follow_button'] = '<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>'
                    . '<g:plus height="69" width="170" href="https://plus.google.com/' . $socUser['id'] . '" rel="author"></g:plus>';


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
            $userFeed = self::makeRequest('https://www.googleapis.com/plus/v1/people/' . $socUsername . '/activities/public?key=' . Yii::app()->eauth->services['google_oauth']['key']);

            unset($post);
            $i = 0;

            if ((strpos($link, '/posts/') !== false) && strlen($link) > (strpos($link, '/posts/') + strlen('/posts/'))) {
                //привязан пост
                while (!isset($post)) {
                    if (isset($userFeed['items']) && isset($userFeed['items'][$i]) && isset($userFeed['items'][$i]['url']) && self::parsePostSlug($userFeed['items'][$i]['url']) == self::parsePostSlug($link)) {
                        $post = $userFeed['items'][$i];
                    } elseif (isset($userFeed['items']) && count($userFeed['items']) > 0 && !isset($userFeed['items'][$i]) && isset($userFeed['nextPageToken'])) {
                        //следующая страница
                        $userFeed = self::makeRequest('https://www.googleapis.com/plus/v1/people/'
                                        . $socUsername . '/activities/public?key=' . Yii::app()->eauth->services['google_oauth']['key']
                                        . '&pageToken=' . $userFeed['nextPageToken']
                        );
                        $i = 0;
                    } elseif (!isset($userFeed['items']) || (!isset($userFeed['items'][$i]))) {
                        $post = 'no';
                    } else {
                        $i++;
                    }
                }
            } else {
                //привязан профиль
                while (!isset($post)) {
                    if (isset($userFeed['items']) && isset($userFeed['items'][$i]) && isset($userFeed['items'][$i]['actor']) && isset($userFeed['items'][$i]['actor']['id']) && ($userFeed['items'][$i]['actor']['id'] == $socUser['id']) && isset($userFeed['items'][$i]['object'])) {
                        $post = $userFeed['items'][$i];
                    } elseif (isset($userFeed['items']) && count($userFeed['items']) > 0 && !isset($userFeed['items'][$i]) && isset($userFeed['nextPageToken'])) {
                        //следующая страница
                        $userFeed = self::makeRequest('https://www.googleapis.com/plus/v1/people/'
                                        . $socUsername . '/activities/public?key=' . Yii::app()->eauth->services['google_oauth']['key']
                                        . '&pageToken=' . $userFeed['nextPageToken']
                        );
                        $i = 0;
                    } elseif (!isset($userFeed['items']) || (!isset($userFeed['items'][$i]))) {
                        $post = 'no';
                    } else {
                        $i++;
                    }
                }
            }

            if ($post != 'no') {
                if (isset($post['object']['content']))
                    $userDetail['last_status'] = strip_tags($post['object']['content'], '<p><br>');
                $userDetail['sub-line'] = '';
                if (isset($post['access']) && !empty($post['access']['description']) && ($post['access']['description'] == 'Public')) {
                    $userDetail['sub-line'] = Yii::t('social', 'Shared publicly');
                }
                if (!empty($post['published'])) {
                    if (empty($userDetail['sub-line']))
                        $userDetail['sub-line'] = date('F j, Y', strtotime($post['published']));
                    else
                        $userDetail['sub-line'] .= ' - ' . date('F j, Y', strtotime($post['published']));
                }

                //Картинка
                if (isset($post['object']['attachments'])) {
                    $i = 0;
                    unset($imgSrc);
                    while (isset($post['object']['attachments'][$i]) && !isset($imgSrc)) {
                        if (isset($post['object']['attachments'][$i]['fullImage']) && !empty($post['object']['attachments'][$i]['fullImage']['url']) && ($post['object']['attachments'][$i]['fullImage']['url'] != ' https:')) {
                            $imgSrc = $post['object']['attachments'][$i]['fullImage']['url'];
                        } elseif (isset($post['object']['attachments'][$i]['image']) && !empty($post['object']['attachments'][$i]['image']['url']) && ($post['object']['attachments'][$i]['image']['url'] != ' https:')) {
                            $imgSrc = $post['object']['attachments'][$i]['image']['url'];
                        } else
                            $i++;
                    }
                    if (!empty($imgSrc)) {
                        $userDetail['last_img'] = $imgSrc;
                        if (isset($post['object']['attachments'][$i]['displayName']) && (strlen($post['object']['attachments'][$i]['displayName']) > 0))
                            $userDetail['last_img_msg'] = strip_tags($post['object']['attachments'][$i]['displayName'], '<p><br>');
                        elseif (isset($post['object']['attachments'][$i]['content']) && (strlen($post['object']['attachments'][$i]['content']) > 0))
                            $userDetail['last_img_msg'] = strip_tags($post['object']['attachments'][$i]['content'], '<p><br>');
                        elseif (isset($userDetail['last_status'])) {
                            $userDetail['last_img_msg'] = $userDetail['last_status'];
                            unset($userDetail['last_status']);
                        }
                        if (isset($post['object']['attachments'][$i]['url']))
                            $userDetail['last_img_href'] = $post['object']['attachments'][$i]['url'];
                    }
                }

                if (self::contentNeedSave($link)) {
                    if (!empty($userDetail['last_img'])) {
                        $savedImg = self::saveImage($userDetail['last_img']);
                        if ($savedImg)
                            $userDetail['last_img'] = $savedImg;
                    }
                    $userDetail['soc_url'] = $link;
                }
            }
        }else {
            $userDetail['error'] = Yii::t('social', "This account doesn't exist:") . $socUsername;
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

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'google.com') !== false) {
            if (strpos($username, 'google.com/u/0/') !== false) {
                $username = substr($username, (strpos($username, 'google.com/u/0/') + 15));
            }
            if (strpos($username, 'google.com/') !== false) {
                $username = substr($username, (strpos($username, 'google.com/') + 11));
            }
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function parsePostSlug($link)
    {
        $slug = '';
        if (strpos($link, 'google.com') !== false && (strpos($link, '/posts/') !== false) && strlen($link) > (strpos($link, '/posts/') + strlen('/posts/'))) {
            $slug = substr($link, (strpos($link, '/posts/') + strlen('/posts/')));
            $slug = self::rmGetParam($slug);
        }

        return $slug;
    }

    public static function contentNeedSave($link)
    {
        $result = false;
        if (strpos($link, 'google.com') !== false && (strpos($link, '/posts/') !== false) && strlen($link) > (strpos($link, '/posts/') + strlen('/posts/')))
            $result = true;

        return $result;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['google_oauth_id']))
            $answer = true;

        return $answer;
    }

}
