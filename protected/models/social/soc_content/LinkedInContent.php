<?php

class LinkedInContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $result = Yii::t('eauth', "Please log in with your LinkedIn account to perform this action");

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
                            $result = Yii::t('eauth', "You are not allowed to use page of another person in your spot");

                            if (!empty($socUser['id']) and $socUser['id'] = $socToken->soc_id)
                                $result = 'ok';
                        }
                    }
                }
            }
        }

        return $result;
    }

    public static function getContent($link, $discodesId = null, $dataKey = null)
    {
        $userDetail = array();
        $userDetail['block_type'] = self::TYPE_LIST;
        $getProfile = false;

        if (!empty($discodesId) && is_numeric($discodesId)) {
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
                    //$url = 'http://api.linkedin.com/v1/people/url='.urlencode($link);
                    //$token = new OAuthToken(Yii::app()->eauth->services['linkedin']['token'], Yii::app()->eauth->services['linkedin']['token_secret']);
                    $token = new OAuthToken($oauth_token, $token_secret);
                    $url = 'http://api.linkedin.com/v1/people/id=' . $socToken->soc_id . ':(id,first-name,last-name,public-profile-url,headline,picture-url,educations,positions)';
                    $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
                    $options = array();
                    $query = null;
                    $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $url, $query);
                    $request->sign_request($signatureMethod, $consumer, $token);
                    $answer = self::makeRequest($request->to_url(), $options, false);

                    if (strpos($answer, 'error:') === false) {
                        $getProfile = true;
                        $socUser = self::xmlToArray(simplexml_load_string($answer));

                        $userDetail['soc_username'] = $socUser['first-name'] . ' ' . $socUser['last-name'];
                        if (!empty($socUser['picture-url']))
                            $userDetail['photo'] = (string) $socUser['picture-url'];
                        if (!empty($socUser['headline']))
                            $userDetail['sub-line'] = (string) $socUser['headline'];
                        if (!empty($socUser['public-profile-url']))
                            $userDetail['soc_url'] = (string) $socUser['public-profile-url'];
                        $userDetail['list'] = array();
                        $userDetail['list']['values'] = array();

                        $currentPosition = '';
                        $positionString = '';
                        $educationString = '';
                        if (isset($socUser['positions']) && isset($socUser['positions']['@attributes']) && !empty($socUser['positions']['@attributes']['total']) && isset($socUser['positions']['position'])) {
                            if ($socUser['positions']['@attributes']['total'] > 1) {
                                for ($i = 0; $i < $socUser['positions']['@attributes']['total']; $i++) {
                                    if (isset($socUser['positions']['position'][$i])) {
                                        $position = self::xmlToArray($socUser['positions']['position'][$i]);
                                        if (isset($position['company']) && !empty($position['company']['name']) && isset($position['is-current'])) {
                                            if ($position['is-current'] == 'true') {
                                                $currentPosition = $position['company']['name'];
                                            } elseif (!$positionString)
                                                $positionString = (string) $position['company']['name'];
                                            else
                                                $positionString .= ', ' . (string) $position['company']['name'];
                                        }
                                    }
                                }
                            } elseif (isset($socUser['positions']['position']['company']) && !empty($socUser['positions']['position']['company']['name']) && isset($socUser['positions']['position']['is-current'])) {
                                if ($socUser['positions']['position']['is-current'] == 'true')
                                    $currentPosition = $socUser['positions']['position']['company']['name'];
                                else
                                    $positionString = $socUser['positions']['position']['company']['name'];
                            }
                        }

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

                        if ($currentPosition) {
                            $userPosition = array();
                            $userPosition['title'] = Yii::t('eauth', "Текущая");
                            $userPosition['comment'] = $currentPosition;
                            $userDetail['list']['values'][] = $userPosition;
                        }

                        if ($positionString) {
                            $userPosition = array();
                            $userPosition['title'] = Yii::t('eauth', "Предыдущие");
                            $userPosition['comment'] = $positionString;
                            $userDetail['list']['values'][] = $userPosition;
                        }

                        if ($educationString) {
                            $userEducation = array();
                            $userEducation['title'] = Yii::t('eauth', "Образование");
                            $userEducation['comment'] = $educationString;
                            $userDetail['list']['values'][] = $userEducation;
                        }
                    }
                }
            }
        }
        if (!$getProfile) {
            $userDetail['last_status'] = $link;
        }

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

}
