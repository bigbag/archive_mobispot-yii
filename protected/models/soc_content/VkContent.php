<?php

class VkContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $url = 'https://api.vk.com/method/users.get.json?uids=' . $socUsername;
        $socUser = self::makeRequest($url);
        if (empty($socUser['response']) || empty($socUser['response'][0]) || empty($socUser['response'][0]['uid']))
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);
        
        $url = 'https://api.vk.com/method/users.get.json?user_ids=' . $socUsername . '&fields=uid,first_name,last_name,nickname,screen_name,photo,photo_medium';
//'&fields=uid,first_name,last_name,nickname,screen_name,sex,bdate(birthdate),city,country,timezone,photo,photo_medium,photo_big,has_mobile,rate,contacts,education,online,counters';
        $curl_result = self::makeRequest($url);
        
        if (!(is_string($curl_result) && (strpos($curl_result, 'error:') !== false)) && isset($curl_result['response']) && !empty($curl_result['response'][0]) && empty($curl_result['response'][0]['error']))
        {
            $socUser = $curl_result['response'][0];
            if (!empty($socUser['photo_medium']))
                $userDetail['photo'] = $socUser['photo_medium'];
            elseif (!empty($socUser['photo']))
                $userDetail['photo'] = $socUser['photo'];
            
            if (!empty($socUser['first_name'])) 
            {
                $userDetail['soc_username'] = $socUser['first_name'];
                if (!empty($socUser['last_name']))
                    $userDetail['soc_username'] .= ' ' . $socUser['last_name'];
            }
            
            if (!empty($socUser['screen_name']))
                $userDetail['soc_url'] = 'http://vk.com/' . $socUser['screen_name'];
            
            //Последний пост
            if (isset($socUser['uid']))
            {

                $userFeed = self::makeRequest('https://api.vk.com/method/wall.get?owner_id=' . $socUser['uid'] . '&filter=owner');

                unset($lastPost);
                $i = 0;
                $prevPageUrl = '';

                while (!isset($lastPost))
                {
                    if (isset($userFeed['response']) && isset($userFeed['response'][$i]) && isset($userFeed['response'][$i]['from_id']) && ($userFeed['response'][$i]['from_id'] == $socUser['uid']))
                    {
                        $lastPost = $userFeed['response'][$i];
                    }
                    elseif (!isset($userFeed['response']) || ($i >= count($userFeed['response'])) || (!isset($userFeed['response'][$i])))
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
                    if (!empty($lastPost['text']))
                        $userDetail['last_status'] = $lastPost['text'];
                    if (!empty($lastPost['date']))
                        $userDetail['footer-line'] = Yii::t('eauth', 'last post') . ' ' . SocContentBase::timeDiff(time() - $lastPost['date']);
                    if (isset($lastPost['attachment']) && isset($lastPost['attachment']['type']))
                    {
                        switch ($lastPost['attachment']['type'])
                        {
                            case 'photo':
                                if (isset($lastPost['attachment']['photo']) && !empty($lastPost['attachment']['photo']['src']))
                                {
                                    $userDetail['last_img'] = $lastPost['attachment']['photo']['src'];
                                    if (!empty($lastPost['text']))
                                        $userDetail['last_img_msg'] = $lastPost['text'];
                                    unset($userDetail['last_status']);
                                }
                                break;
                            case 'posted_photo':
                                if (isset($lastPost['attachment']['photo']) && !empty($lastPost['attachment']['photo']['src']))
                                {
                                    $userDetail['last_img'] = $lastPost['attachment']['photo']['src'];
                                    if (!empty($lastPost['text']))
                                        $userDetail['last_img_msg'] = $lastPost['text'];
                                    unset($userDetail['last_status']);
                                }
                                elseif (isset($lastPost['attachment']['posted_photo']) && !empty($lastPost['attachment']['posted_photo']['src']))
                                {
                                    $userDetail['last_img'] = $lastPost['attachment']['posted_photo']['src'];
                                    if (!empty($lastPost['text']))
                                        $userDetail['last_img_msg'] = $lastPost['text'];
                                    unset($userDetail['last_status']);
                                }
                                break;
                            case 'link':
                                if (isset($lastPost['attachment']['link']) && isset($lastPost['attachment']['link']['image_src']) && isset($lastPost['attachment']['link']['url']))
                                {
                                    $userDetail['last_img'] = $lastPost['attachment']['link']['image_src'];
                                    $userDetail['last_img_href'] = $lastPost['attachment']['link']['url'];
                                    if (!empty($lastPost['attachment']['link']['title']))
                                        $userDetail['last_img_msg'] = $lastPost['attachment']['link']['title'];
                                    if (!empty($lastPost['attachment']['link']['description']))
                                        $userDetail['last_img_story'] = $lastPost['attachment']['link']['description'];
                                }
                                elseif (isset($lastPost['attachment']['link']) && !empty($lastPost['attachment']['link']['url']))
                                {
                                    $userDetail['link_href'] = $lastPost['attachment']['link']['url'];
                                    $userDetail['link_text'] = '';
                                    if (!empty($lastPost['attachment']['link']['title']))
                                        $userDetail['link_text'] .= $lastPost['attachment']['link']['title'] . '<br/>';
                                    if (!empty($lastPost['text']))
                                        $userDetail['link_text'] .= $lastPost['text'];
                                    unset($userDetail['last_status']);
                                    if (!empty($lastPost['attachment']['link']['description']))
                                        $userDetail['link_descr'] = $lastPost['attachment']['link']['description'];
                                }
                                break;
                            case 'video':
                                if (isset($lastPost['attachment']['video']) && !empty($lastPost['attachment']['video']['image']))
                                {
                                    $userDetail['last_img'] = $lastPost['attachment']['video']['image'];
                                    if (!empty($lastPost['text']))
                                        $userDetail['last_img_msg'] = $lastPost['text'];
                                    unset($userDetail['last_status']);
                                }
                                break;
                        }
                    }
                }
            }
        }
        else
        {
            $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }
        
        return $userDetail;
    }
    
    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'vk.com/') !== false)
        {
            $username = substr($username, (strpos($username, 'vk.com/') + 7));
            $username = self::rmGetParam($username);
        }
        return $username;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['vk_id']))
            $answer = true;
        
        return $answer;
    }
}