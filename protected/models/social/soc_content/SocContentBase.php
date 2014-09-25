<?php

class SocContentBase
{
    const TYPE_TWEET = 'tweet';
    const TYPE_POST = 'post';
    const TYPE_SHARED_LINK = 'shared_link';
    const YOUTUBE_VIDEO = 'youtube_video';
    const VIMEO_VIDEO = 'vimeo_video';
    const INSTAGRAM_PHOTO = 'instagram_photo';
    const TYPE_CHECKIN = 'checkin';
    const TYPE_LIST = 'list';

    public static function rmGetParam($str)
    {
        if (strpos($str, '?') > 0)
            $str = substr($str, 0, strpos($str, '?'));
        if ((strpos($str, '/') > 0) && ((strpos($str, 'http://')) === false ))
            $str = substr($str, 0, strpos($str, '/'));
        if (strpos($str, '&') > 0)
            $str = substr($str, 0, strpos($str, '&'));
        if (strpos($str, '#') > 0)
            $str = substr($str, 0, strpos($str, '#'));
        return $str;
    }

    public static function contentNeedSave($link)
    {
        return false;
    }

    public static function initRequest($url, $options = array())
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');

        if (isset($options['referer']))
            curl_setopt($ch, CURLOPT_REFERER, $options['referer']);

        if (isset($options['headers']))
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);

        if (isset($options['query'])) {
            $url_parts = parse_url($url);
            if (isset($url_parts['query'])) {
                $query = $url_parts['query'];
                if (strlen($query) > 0)
                    $query .= '&';
                $query .= http_build_query($options['query']);
                $url = str_replace($url_parts['query'], $query, $url);
            } else {
                $url_parts['query'] = $options['query'];
                $new_query = http_build_query($url_parts['query']);
                $url .= '?' . $new_query;
            }
        }

        if (isset($options['data'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $options['data']);
        }

        return $ch;
    }

    public static function makeRequest($url, $options = array(), $parseJson = true)
    {
        $ch = self::initRequest($url, $options);

        try {
            $result = curl_exec($ch);
        } catch (Exception $e) {
            Yii::log(
                    'Curl exception: ' . $e->getMessage() . PHP_EOL .
                    'URL: ' . $url . PHP_EOL .
                    'Options: ' . var_export($options, true)
                    , 'error', 'application'
            );
        }

        $headers = curl_getinfo($ch);

        //if (curl_errno($ch) > 0)
        //    throw new CException(curl_error($ch), curl_errno($ch));

        if (isset($headers['http_code']) && $headers['http_code'] != 200) {
            Yii::log(
                    'Invalid response http code: ' . $headers['http_code'] . '.' . PHP_EOL .
                    'URL: ' . $url . PHP_EOL .
                    'Options: ' . var_export($options, true) . PHP_EOL .
                    'Result: ' . $result, 'error', 'application'
            );
            $result = 'error:' . $headers['http_code'];
        } elseif (!isset($headers['http_code']))
            $result = 'error:';
        elseif ($parseJson)
            $result = CJSON::decode($result, true);
        curl_close($ch);

        return $result;
    }

    public static function saveImage($url)
    {
        $web_name = false;

        $fileType = strtolower(substr(strrchr($url, '.'), 1));
        $images = array('jpeg' => 'jpeg', 'jpg' => 'jpg', 'png' => 'png', 'gif' => 'gif');

        if (isset($images[$fileType])) {
            $file = md5(time() . $url) . '_' . str_replace('.' . $images[$fileType], '', self::urlToName($url)) . '.' . $images[$fileType];

            $patch = Yii::getPathOfAlias('webroot.uploads.spot.') . '/';
            $file_name = $patch . $file;

            $i = 0;
            while (file_exists($file_name)) {
                $file = md5((time() + $i) . $url) . '_' . self::urlToName($url);
                $file_name = $patch . $file;
                $i++;
            }

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:16.0) Gecko/20120815 Firefox/16.0');
            curl_setopt($ch, CURLOPT_CAINFO, Yii::app()->params['ssl']);
            $rawdata = curl_exec($ch);
            curl_close($ch);

            $fp = fopen($file_name, 'x');
            fwrite($fp, $rawdata);
            fclose($fp);

            $web_name = '/uploads/spot/' . $file;
        }

        return $web_name;
    }

    public static function urlToName($url)
    {
        $to_delete = array(':', 'http://', 'https://', '%');
        return self::rmGetParam(str_replace('/', '_', str_ireplace($to_delete, '', $url)));
    }

    public static function timeDiff($diff)
    {
        $answer = '';
        if ($diff > 31104000)
            $answer = ((int) floor($diff / 31104000)) . ' ' . Yii::t('social', 'years ago');
        elseif ($diff > 2592000)
            $answer = ((int) floor($diff / 2592000)) . ' ' . Yii::t('social', 'months ago');
        elseif ($diff > 86400)
            $answer = ((int) floor($diff / 86400)) . ' ' . Yii::t('social', 'days ago');
        elseif ($diff > 3600)
            $answer = ((int) floor($diff / 3600)) . ' ' . Yii::t('social', 'hours ago');
        elseif ($diff > 60)
            $answer = ((int) floor($diff / 60)) . ' ' . Yii::t('social', 'minutes ago');
        else
            $answer = $diff . ' ' . Yii::t('social', 'seconds ago');

        return $answer;
    }

    public static function parseParam($string, $param)
    {
        $answer = '';
        if (strpos($string, $param) !== false) {
            $answer = substr($string, (strpos($string, $param) + strlen($param)));
            $answer = self::rmGetParam($answer);
        }

        return $answer;
    }

    public static function checkToken($user_token, $token_secret = '')
    {
        return null;
    }

    public static function checkSharing($loyalty)
    {
        return false;
    }

    public static function clueImgText($userDetail)
    {
        $text = '';
        if (!empty($userDetail['text']))
            $text .= $userDetail['text'].' ';
        if (!empty($userDetail['last_status']))
            $text .= $userDetail['last_status'].' ';
        if (!empty($userDetail['last_img_msg']))
            $text .= $userDetail['last_img_msg'].' ';
        if (!empty($userDetail['last_img_story']))
            $text .= $userDetail['last_img_story'].' ';

        return $text;
    }

}
