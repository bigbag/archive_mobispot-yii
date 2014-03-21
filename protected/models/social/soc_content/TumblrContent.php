<?php

class TumblrContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';

        $socUsername = self::parseUsername($link);

        $blogInfo = self::makeRequest('http://api.tumblr.com/v2/blog/' . $socUsername . '/info?api_key=' . Yii::app()->eauth->services['tumblr']['key']);
        if ((is_string($blogInfo) && (strpos($blogInfo, 'error:') !== false)) || !isset($blogInfo['response']) || !isset($blogInfo['response']['blog']))
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $needSave = self::contentNeedSave($link);
        $socUsername = self::parseUsername($link);

        $url = 'http://api.tumblr.com/v2/blog/' . $socUsername . '/posts?api_key=' . Yii::app()->eauth->services['tumblr']['key'] . '&limit=1';

        if (strpos($link, '/post/') !== false && strlen($link) > (strpos($link, '/post/') + strlen('/post/')))
        {
            $postId = substr($link, (strpos($link, '/post/') + strlen('/post/')));
            $postId = self::rmGetParam($postId);
            $url .= '&id=' . $postId;
        }

        $blogInfo = self::makeRequest($url);
        if (!(is_string($blogInfo) && (strpos($blogInfo, 'error:') !== false)) and isset($blogInfo['response']) and isset($blogInfo['response']['blog']))
        {

            if (!empty($blogInfo['response']['blog']['title']))
                $userDetail['soc_username'] = $blogInfo['response']['blog']['title'];
            elseif (!empty($blogInfo['response']['blog']['name']))
                $userDetail['soc_username'] = $blogInfo['response']['blog']['name'];
            $userDetail['photo'] = 'http://api.tumblr.com/v2/blog/' . $socUsername . '/avatar';
            if (!empty($blogInfo['response']['blog']['url']))
                $userDetail['soc_url'] = $blogInfo['response']['blog']['url'];
            /* if (self::isLoggegByNet())
              {
              Yii::import('ext.eoauth.*');
              $consumer = new OAuthConsumer(Yii::app()->eauth->services['tumblr']['key'], Yii::app()->eauth->services['tumblr']['secret']);
              $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https://' : 'http://';
              $callbackUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
              $token = Yii::app()->session['tumblr_token'];
              $url = 'http://api.tumblr.com/v2/user/following';
              $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
              $options = array();
              $query = null;
              $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $url, $query);
              $request->sign_request($signatureMethod, $consumer, $token);

              $followersRusult = self::makeRequest($request->to_url(), $options, true);

              } */
            if (!empty(Yii::app()->session['tumblr_follow_' . $socUsername]) && !$needSave)
            {
                $userDetail['invite'] = Yii::t('eauth', 'You\'re following ') . $blogInfo['response']['blog']['title'];
            }
            else
            {
                $userDetail['follow_service'] = 'tumblr';
                $userDetail['follow_param'] = urlencode($socUsername);
            }

            if ($needSave)
            {
                $userDetail['check_following'] = 'tumblr_follow_' . $socUsername;
                $userDetail['message_following'] = Yii::t('eauth', 'You\'re following ') . $blogInfo['response']['blog']['title'];
            }

            if (isset($blogInfo['response']['posts']) and isset($blogInfo['response']['posts'][0]) and isset($blogInfo['response']['posts'][0]['type']))
            {
                $lastPost = $blogInfo['response']['posts'][0];

                if ($lastPost['type'] == 'text')
                {
                    if (isset($lastPost['format']) and $lastPost['format'] == 'html' and isset($lastPost['body']))
                        $userDetail['html'] = $lastPost['body'];
                }
                elseif ($lastPost['type'] == 'photo')
                {
                    if (isset($lastPost['photos']) and isset($lastPost['photos'][0]) and isset($lastPost['photos'][0]['original_size']) and !empty($lastPost['photos'][0]['original_size']['url']))
                    {
                        $userDetail['last_img'] = $lastPost['photos'][0]['original_size']['url'];
                        if (!empty($lastPost['post_url']))
                            $userDetail['last_img_href'] = $lastPost['post_url'];
                        if (!empty($lastPost['caption']))
                            $userDetail['last_img_msg'] = strip_tags($lastPost['caption'], '<p><br>');
                    }
                }
                elseif ($lastPost['type'] == 'quote')
                {
                    if (!empty($lastPost['text']) && !empty($lastPost['source_url']))
                    {
                        $userDetail['link_text'] = $lastPost['text'];
                        $userDetail['link_href'] = htmlspecialchars($lastPost['source_url']);
                    }
                    elseif (!empty($lastPost['text']))
                        $userDetail['last_status'] = $lastPost['text'];
                }
                elseif ($lastPost['type'] == 'video')
                {
                    $userDetail['html'] = '';
                    if (!empty($lastPost['caption']))
                        $userDetail['html'] .= '<p>' . $lastPost['caption'] . '</p>';
                    if (!empty($lastPost['player']) && is_array($lastPost['player']) && isset($lastPost['player'][(count($lastPost['player']) - 1)]['embed_code']))
                        $userDetail['html'] .= $lastPost['player'][(count($lastPost['player']) - 1)]['embed_code'];
                }
                elseif ($lastPost['type'] == 'audio')
                {
                    $userDetail['html'] = '';
                    if (!empty($lastPost['caption']))
                        $userDetail['html'] .= '<p>' . $lastPost['caption'] . '</p>';
                    if (!empty($lastPost['embed']))
                        $userDetail['html'] .= $lastPost['embed'];
                }
                elseif ($lastPost['type'] == 'link')
                {
                    if (!empty($lastPost['url']) && !empty($lastPost['description']))
                    {
                        $userDetail['link_href'] = $lastPost['url'];
                        if (!empty($lastPost['title']))
                            $userDetail['link_text'] = '<p>' . strip_tags($lastPost['title']) . '</p>' . strip_tags($lastPost['description'], '<p><br><img>');
                        else
                            $userDetail['link_text'] = strip_tags($lastPost['description'], '<p><br><img>');
                    }
                }
                elseif ($lastPost['type'] == 'answer')
                {
                    $userDetail['html'] = '';
                    if (!empty($lastPost['asking_name']))
                    {
                        $userDetail['html'] .= $lastPost['asking_name'];
                        if (!empty($lastPost['question']))
                            $userDetail['html'] .= ':' . $lastPost['question'];
                        $userDetail['html'] = '<p>' . $userDetail['html'] . '</p>';
                    }
                    if (!empty($lastPost['answer']))
                    {
                        $userDetail['html'] .= '<p>' . $lastPost['blog_name'] . ':' . $lastPost['answer'] . '</p>';
                    }
                }
                else
                {
                    $userDetail['last_status'] = print_r($lastPost, true);
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
        }
        else
        {
            $userDetail['error'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }

        return $userDetail;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['tumblr_token']))
            $answer = true;

        return $answer;
    }

    public static function contentNeedSave($link)
    {
        $result = false;
        if (strpos($link, '/post/') !== false && strlen($link) > (strpos($link, '/post/') + strlen('/post/')))
            $result = true;

        return $result;
    }

    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'https://') !== false)
            $username = substr($username, (strpos($username, 'https://') + strlen('https://')));
        if (strpos($username, 'http://') !== false)
            $username = substr($username, (strpos($username, 'http://') + strlen('http://')));
        $username = self::rmGetParam($username);

        return $username;
    }

    public static function followSocial($blogUrl)
    {
        $answer = array();
        $answer['error'] = 'yes';

        if (!empty($blogUrl) && !empty(Yii::app()->session['tumblr_token']))
        {
            Yii::import('ext.eoauth.*');
            $consumer = new OAuthConsumer(Yii::app()->eauth->services['tumblr']['key'], Yii::app()->eauth->services['tumblr']['secret']);
            $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https://' : 'http://';
            $callbackUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
            $token = Yii::app()->session['tumblr_token'];
            $url = 'http://api.tumblr.com/v2/user/follow';
            $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
            $options = array('data' => 'url=' . $blogUrl);
            $query = array('url' => $blogUrl);
            $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'POST', $url, $query);
            $request->sign_request($signatureMethod, $consumer, $token);

            $followRusult = self::makeRequest($request->to_url(), $options, true);

            if (isset($followRusult['meta']) && isset($followRusult['meta']['msg']) && $followRusult['meta']['msg'] == 'OK')
            {
                $answer['error'] = 'no';

                $blogInfo = self::makeRequest('http://api.tumblr.com/v2/blog/' . $blogUrl . '/info?api_key=' . Yii::app()->eauth->services['tumblr']['key']);
                if (isset($blogInfo['response']) && isset($blogInfo['response']['blog']) && !empty($blogInfo['response']['blog']['name']))
                    $answer['message'] = Yii::t('eauth', 'You\'re following ') . $blogInfo['response']['blog']['name'];
            }
        }

        return $answer;
    }

}
