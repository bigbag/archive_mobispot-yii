<?php

class DeviantARTContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = self::parseUsername($link);
        $result = 'ok';

        $options = array();
        $ch = self::initRequest('http://' . $socUsername . '.deviantart.com', $options);
        $socUser = curl_exec($ch);
        $headers = curl_getinfo($ch);
        if ($headers['http_code'] != 200)
        {
            $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $socUsername = self::parseUsername($link);
        
        $options = array();
        $ch = self::initRequest('http://' . $socUsername . '.deviantart.com', $options, false);
        $socUser = curl_exec($ch);
        $headers = curl_getinfo($ch);
        if ($headers['http_code'] == 200)
        {
            //$userDetail['soc_username'] = $socUsername;
            $userDetail['soc_url'] = 'http://' . $socUsername . '.deviantart.com';

            $userLent = self::makeRequest('http://backend.deviantart.com/rss.xml?q=by%3A' . $socUsername . '+sort%3Atime+meta%3Aall', $options, false);

            if (!empty($userLent) && !(is_string($userLent) && (strpos($userLent, 'error:') !== false)))
                $xml = new SimpleXMLElement($userLent);

            $i = 0; //оставлено под счетчик, если требуется вытащить более одной записи

            if (!empty($userLent) && !(is_string($userLent) && (strpos($userLent, 'error:') !== false)) && isset($xml) && isset($xml->channel) && isset($xml->channel->item) && isset($xml->channel->item[$i]) && isset($xml->channel->item[$i]->link))
            {
                $dev_link = (string) $xml->channel->item[$i]->link;
                $last_dev = self::makeRequest('http://backend.deviantart.com/oembed?url=' . $dev_link);

                if (!empty($last_dev['title']))
                {
                    $userDetail['color-header'] = $last_dev['title'];
                    if (!empty($last_dev['author_name']) && !empty($last_dev['author_url']))
                    $userDetail['sub-line'] = Yii::t('eauth', "by") . ' <a href="' . $last_dev['author_url'] . '">' . $last_dev['author_name'] . '</a>';
                    $userDetail['footer-line'] = '';
                    if (!empty($last_dev['category']))
                        $userDetail['footer-line'] .= '<div>' . str_replace('>', '/', $last_dev['category']) . '</div>';
                    if (!empty($xml->channel->copyright))
                        $userDetail['footer-line'] .= '<p>' . str_replace('Copyright ', '©', (string)$xml->channel->copyright) . '</p>';
                    if (!empty($last_dev['url']) || !empty($last_dev['thumbnail_url']))
                    {
                        if (!empty($last_dev['url']))
                            $userDetail['last_img'] = $last_dev['url'];
                        else
                            $userDetail['last_img'] = $last_dev['thumbnail_url'];
                        //$userDetail['last_img_msg'] = $last_dev['title'];
                        unset($userDetail['last_status']);
                        /*
                        if (!empty($xml->channel->item[$i]->description))
                        {
                            $userDetail['last_img_story'] = strip_tags((string)$xml->channel->item[$i]->description, '<p><br>');
                            if (strpos($userDetail['last_img_story'], '<br') !== false)
                                $userDetail['last_img_story'] = substr($userDetail['last_img_story'], 0, strpos($userDetail['last_img_story'], '<br'));
                            if (strpos($userDetail['last_img_story'], '<div') !== false)
                                $userDetail['last_img_story'] = substr($userDetail['last_img_story'], 0, strpos($userDetail['last_img_story'], '<div'));
                        }
                        */
                    }
                }
            }
        }
        else
            $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;  
                    
        return $userDetail;
    }
        
    public static function parseUsername($link)
    {
        $username = $link;
        if (strpos($username, 'http://') !== false)
            $username = substr($username, (strpos($username, 'http://') + 7));
        if (strpos($username, 'deviantart.com') !== false)
            $username = substr($username, 0, (strpos($username, 'deviantart.com') - 1));
        if (strpos($username, 'http://') !== false)
            $username = 'strpos:' . strpos($username, 'http://');
        return $username;
    }
    
    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['deviantart_id']))
            $answer = true;
        
        return $answer;
    }
}