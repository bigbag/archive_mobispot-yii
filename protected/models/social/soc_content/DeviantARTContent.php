<?php

class DeviantARTContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = 'ok';

        if (strpos($link, 'deviantart.com/art/') !== false) {
            $post = self::makeRequest('http://backend.deviantart.com/oembed?url=' . $link);
            if ((is_string($post) && (strpos($post, 'error:') !== false)) || empty($post['title']))
                $result = Yii::t('eauth', "This post doesn't exist:") . $link;
        } else {
            $socUsername = self::parseUsername($link);

            $ch = self::initRequest('http://' . $socUsername . '.deviantart.com', array());
            $socUser = curl_exec($ch);
            $headers = curl_getinfo($ch);
            if ($headers['http_code'] != 200) {
                $result = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
            }
        }

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();

        if (strpos($link, 'deviantart.com/art/') !== false) {
            $postDetail = self::getPostContent($link);
            if (empty($postDetail['error']) && !empty($postDetail['color-header']))
                foreach ($postDetail as $postKey => $postValue)
                    $userDetail[$postKey] = $postValue;
            if (!empty($userDetail['last_img']))
                $userDetail['last_img'] = self::saveImage($userDetail['last_img']);
        } else {
            $socUsername = self::parseUsername($link);

            $ch = self::initRequest('http://' . $socUsername . '.deviantart.com', array(), false);
            $socUser = curl_exec($ch);
            $headers = curl_getinfo($ch);
            if ($headers['http_code'] == 200) {
                //$userDetail['soc_username'] = $socUsername;
                $userDetail['soc_url'] = 'http://' . $socUsername . '.deviantart.com';

                $userLent = self::makeRequest('http://backend.deviantart.com/rss.xml?q=by%3A' . $socUsername . '+sort%3Atime+meta%3Aall', array(), false);

                if (!empty($userLent) && !(is_string($userLent) && (strpos($userLent, 'error:') !== false)))
                    $xml = new SimpleXMLElement($userLent);

                $i = 0; //оставлено под счетчик, если требуется вытащить более одной записи

                if (!empty($userLent) && !(is_string($userLent) && (strpos($userLent, 'error:') !== false)) && isset($xml) && isset($xml->channel) && isset($xml->channel->item) && isset($xml->channel->item[$i]) && isset($xml->channel->item[$i]->link)) {
                    $dev_link = (string) $xml->channel->item[$i]->link;

                    $postDetail = self::getPostContent($dev_link);
                    if (empty($postDetail['error']) && !empty($postDetail['color-header']))
                        foreach ($postDetail as $postKey => $postValue)
                            $userDetail[$postKey] = $postValue;
                }
            } else
                $userDetail['soc_username'] = Yii::t('eauth', "This account doesn't exist:") . $socUsername;
        }

        return $userDetail;
    }

    public static function getPostContent($link)
    {
        $postDetail = array();

        $post = self::makeRequest('http://backend.deviantart.com/oembed?url=' . $link);

        if (!(is_string($post) && (strpos($post, 'error:') !== false)) && !empty($post['title'])) {
            $postDetail['color-header'] = $post['title'];
            if (!empty($post['author_name']) && !empty($post['author_url']))
                $postDetail['sub-line'] = Yii::t('eauth', "by") . ' <a href="' . $post['author_url'] . '">' . $post['author_name'] . '</a>';
            $postDetail['footer-line'] = '';
            if (!empty($post['category']))
                $postDetail['footer-line'] .= '<div>' . str_replace('>', '/', $post['category']) . '</div>';
            if (!empty($xml->channel->copyright))
                $postDetail['footer-line'] .= '<p>' . str_replace('Copyright ', '©', (string) $xml->channel->copyright) . '</p>';
            if (!empty($post['url']) && !empty($post['thumbnail_url'])) {
                if (!empty($post['url']))
                    $postDetail['last_img'] = $post['url'];
                else
                    $postDetail['last_img'] = $post['thumbnail_url'];
                //$postDetail['last_img_msg'] = $post['title'];
                unset($postDetail['last_status']);
                /*
                  if (!empty($xml->channel->item[$i]->description)) {
                  $postDetail['last_img_story'] = strip_tags((string)$xml->channel->item[$i]->description, '<p><br>');
                  if (strpos($postDetail['last_img_story'], '<br') !== false)
                  $postDetail['last_img_story'] = substr($postDetail['last_img_story'], 0, strpos($postDetail['last_img_story'], '<br'));
                  if (strpos($postDetail['last_img_story'], '<div') !== false)
                  $postDetail['last_img_story'] = substr($postDetail['last_img_story'], 0, strpos($postDetail['last_img_story'], '<div'));
                  }
                 */
            }
            if (!empty($post['html']))
                $postDetail['html'] = $post['html'];
        } else
            $postDetail['error'] = Yii::t('eauth', "This post doesn't exist:") . $link;

        return $postDetail;
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

    public static function contentNeedSave($link)
    {
        $result = false;
        if (strpos($link, 'deviantart.com/art/') !== false)
            $result = true;
        return $result;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['deviantart_id']))
            $answer = true;

        return $answer;
    }

}
