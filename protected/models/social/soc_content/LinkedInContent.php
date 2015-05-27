<?php

class LinkedInContent extends SocContentBase
{

    const URL_PROFILE = 'https://api.linkedin.com/v1/people/~:(id,headline,firstName,lastName,emailAddress,pictureUrl,positions,siteStandardProfileRequest)?format=json';
    const PUBLIC_PROFILE = 'https://www.linkedin.com/profile/view?id=';
    
    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        /*
        $result = Yii::t('social', "Please log in with your LinkedIn account to perform this action");

        if (!empty($discodesId) && is_numeric($discodesId) && !empty($dataKey)) {
            $spot = Spot::model()->findByPk($discodesId);
            if ($spot) {
                $socToken = SocToken::model()->findByAttributes(array('user_id' => $spot->user_id, 'type' => SocToken::TYPE_LINKEDIN));
                if ($socToken) {
                    Yii::import('ext.eoauth.*');
                    $consumer = new OAuthConsumer(Yii::app()->eauth->services['linkedin']['key'], Yii::app()->eauth->services['linkedin']['secret']);
                    $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https://' : 'http://';
                    $callbackUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
                    $oauth_token = SocContentBase::parseParam($socToken->user_token, 'oauth_token=');
                    $token_secret = SocContentBase::parseParam($socToken->user_token, 'oauth_token_secret=');
                    $token = new OAuthToken($oauth_token, $token_secret);
                    $url = 'http://api.linkedin.com/v1/people/id=' . $socToken->soc_id . ':(id)';
                    $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
                    $options = array();
                    $query = null;
                    $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $url, $query);
                    $request->sign_request($signatureMethod, $consumer, $token);
                    $answer = self::makeRequest($request->to_url(), $options, false);

                    if (strpos($answer, 'error:') === false) {
                        $socUser = self::xmlToArray(simplexml_load_string($answer));
                        $spotContent = SpotContent::getSpotContent($spot);
                        if ($spotContent) {
                            $content = $spotContent->content;
                            $result = Yii::t('social', "You are not allowed to use page of another person in your spot");

                            if (!empty($socUser['id']) and $socUser['id'] = $socToken->soc_id)
                                $result = 'ok';
                        }
                    }
                }
            }
        }

        return $result;
        */
        return 'ok';
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $userDetail['block_type'] = self::TYPE_LIST;
        $getProfile = false;
        
        if (empty($discodesId) or !is_numeric($discodesId))
            return $userDetail;
        $spot = Spot::model()->findByPk($discodesId);
        if (!$spot)
            return $userDetail;
        
        $token = SocToken::model()->findByAttributes(array('user_id' => $spot->user_id, 'type' => SocToken::TYPE_LINKEDIN));
        if (!$token)
            return $userDetail;
        
        $socUser = LinkedinContent::makeRequest(self::URL_PROFILE, array(), true, $token->user_token);

        $userDetail['soc_username'] = $socUser['firstName'] . ' ' . $socUser['lastName'];
        if (!empty($socUser['pictureUrl']))
            $userDetail['photo'] = (string) $socUser['pictureUrl'];
        if (!empty($socUser['headline']))
            $userDetail['sub-line'] = (string) $socUser['headline'];
        if (!empty($socUser['siteStandardProfileRequest']) and !empty($socUser['siteStandardProfileRequest']['url']))
            $userDetail['soc_url'] = self::filterPublicUrl($socUser['siteStandardProfileRequest']['url']);
        
        $userDetail['list'] = array();
        $userDetail['list']['values'] = array();

        $currentPosition = '';
        $positionString = '';
        $educationString = '';
        if (isset($socUser['positions']) and !empty($socUser['positions']['_total']) and !empty($socUser['positions']['values'])) {
            if ($socUser['positions']['_total'] > 1) {
                for ($i = 0; $i < $socUser['positions']['_total']; $i++) {
                    if (isset($socUser['positions']['values'][$i])) {
                        $position = $socUser['positions']['values'][$i];
                        if (isset($position['company']) && !empty($position['company']['name']) && isset($position['isCurrent'])) {
                            if ($position['isCurrent'] == 1) {
                                $currentPosition = $position['company']['name'];
                            } elseif (!$positionString)
                                $positionString = (string) $position['company']['name'];
                            else
                                $positionString .= ', ' . (string) $position['company']['name'];
                        }
                    }
                }
            } elseif (isset($socUser['positions']['values'][0]['company']) && !empty($socUser['positions']['values'][0]['company']['name']) && isset($socUser['positions']['values'][0]['isCurrent'])) {
                if ($socUser['positions']['values'][0]['isCurrent'] == 1)
                    $currentPosition = $socUser['positions']['values'][0]['company']['name'];
                else
                    $positionString = $socUser['positions']['values'][0]['company']['name'];
            }
        }
/*
        if (isset($socUser['educations']) && isset($socUser['educations']['@attributes']) && !empty($socUser['educations']['@attributes']['total']) && isset($socUser['educations']['education'])) {

            if ($socUser['educations']['@attributes']['total'] > 1) {
                for ($i = 0; $i < $socUser['educations']['@attributes']['total']; $i++) {
                    if (isset($socUser['educations']['education'][$i])) {
                        $education = self::xmlToArray($socUser['educations']['education'][$i]);

                        if (!empty($education['school-name'])) {
                            if (!$educationString)
                                $educationString = (string) $education['school-name'];
                            else
                                $educationString .= ', ' . (string) $education['school-name'];
                        }
                    }
                }
            } elseif (!empty($socUser['educations']['education']['school-name'])) {
                $educationString = $socUser['educations']['education']['school-name'];
            }
        }
*/
        if ($currentPosition) {
            $userPosition = array();
            $userPosition['title'] = Yii::t('social', "Current");
            $userPosition['comment'] = $currentPosition;
            $userDetail['list']['values'][] = $userPosition;
        }

        if ($positionString) {
            $userPosition = array();
            $userPosition['title'] = Yii::t('social', "Previous");
            $userPosition['comment'] = $positionString;
            $userDetail['list']['values'][] = $userPosition;
        }

        if ($educationString) {
            $userEducation = array();
            $userEducation['title'] = Yii::t('social', "Education");
            $userEducation['comment'] = $educationString;
            $userDetail['list']['values'][] = $userEducation;
        }
/*
        if (!$getProfile) {
            $userDetail['last_status'] = $link;
        }
*/
        return $userDetail;
    }

    public static function parseUsername($link)
    {
        return $link;
    }

    protected function xmlToArray($element)
    {
        $array = (array) $element;
        foreach ($array as $key => $value) {
            if (is_object($value))
                $array[$key] = self::xmlToArray($value);
        }
        return $array;
    }

    public static function isLoggegByNet()
    {
        $answer = false;
        if (!empty(Yii::app()->session['linkedin_id']))
            $answer = true;

        return $answer;
    }
    
    public static function makeRequest($url, $options = array(), $parseJson = true, $access_token = false)
    {
        $ch = self::initRequest($url, $options, $access_token);

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
    
    public static function initRequest($url, $options = array(), $access_token)
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

        if (isset($options['headers']) and is_array($options['headers']))
        {
            $options['headers'][] = 'Authorization: Bearer ' . $access_token;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $options['headers']);
        }
        else
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        }

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
    
    public static function filterPublicUrl($url)
    {
        return self::PUBLIC_PROFILE . self::parseParam($url, 'id=');
    }

}
