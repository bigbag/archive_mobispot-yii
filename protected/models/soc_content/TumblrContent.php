<?php

class TumblrContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';
        
        $socUsername = self::parseUsername($link);
        
        $blogInfo = self::makeRequest('http://api.tumblr.com/v2/blog/'.$socUsername.'/info?api_key='.Yii::app()->eauth->services['tumblr']['key']);
        if ((is_string($blogInfo) && (strpos($blogInfo, 'error:') !== false)) || !isset($blogInfo['response']) || !isset($blogInfo['response']['blog']))
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
          
        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);
        
        $blogInfo = self::makeRequest('http://api.tumblr.com/v2/blog/'.$socUsername.'/posts/text?api_key='.Yii::app()->eauth->services['tumblr']['key'].'&limit=1');
        if (!(is_string($blogInfo) && (strpos($blogInfo, 'error:') !== false)) and isset($blogInfo['response']) and isset($blogInfo['response']['blog']))
        {
//$userDetail['last_status'] = print_r($blogInfo, true);
            if (!empty($blogInfo['response']['blog']['title']))
                $userDetail['soc_username'] = $blogInfo['response']['blog']['title'];
            elseif (!empty($blogInfo['response']['blog']['name']))
                $userDetail['soc_username'] = $blogInfo['response']['blog']['name'];
            $userDetail['photo'] = 'http://api.tumblr.com/v2/blog/'.$socUsername.'/avatar';
            if (!empty($blogInfo['response']['blog']['url']))
                $userDetail['soc_url'] = $blogInfo['response']['blog']['url'];
            
            if (isset($blogInfo['response']['posts']) and isset($blogInfo['response']['posts'][0]) and isset($blogInfo['response']['posts'][0]['type']))
            {
                $lastPost = $blogInfo['response']['posts'][0];
                
                if ($lastPost['type'] == 'text')
                {
                    if (isset($lastPost['format']) and $lastPost['format'] == 'html' and isset($lastPost['body']))
                        $userDetail['html'] = $lastPost['body'];
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
                        $userDetail['html'] .= '<p>'.$lastPost['caption'].'</p>';
                    if (!empty($lastPost['player']) && is_array($lastPost['player']) && isset($lastPost['player'][(count($lastPost['player'])-1)]['embed_code']))
                        $userDetail['html'] .= $lastPost['player'][(count($lastPost['player'])-1)]['embed_code'];
                
                }
                
            }
        }
        else
        {
            $userDetail['error'] =  Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }
        
        return $userDetail;
    }
    
    public static function isLoggegByNet()
    {
        $answer = true;

        return $answer;
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
}