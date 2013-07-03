<?php

class LinkedInContent extends SocContentBase
{

    public static function isLinkCorrect($link, $discodesId = null, $dataKey = null)
    {
        $socUsername = $link;
        $result = Yii::t('eauth', "Для этого действия требуется авторизация через LinkedIn!");

        if(!empty($discodesId) && is_numeric($discodesId) && !empty($dataKey)){
            $spot= Spot::model()->findByPk($discodesId);
            if($spot){
                $socToken = SocToken::model()->findByAttributes(array('user_id'=>$spot->user_id, 'type'=>9));
                if($socToken){
                    Yii::import('ext.eoauth.*');
                    $consumer = new OAuthConsumer(Yii::app()->eauth->services['linkedin']['key'], Yii::app()->eauth->services['linkedin']['secret']);
                    $protocol = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? 'https://' : 'http://';
                    $callbackUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
                    parse_str($socToken->user_token, $values);
                    $token = new OAuthToken($values['oauth_token'], $values['oauth_token_secret']);
                    $url = 'http://api.linkedin.com/v1/people/id='.$socToken->soc_id.':(id,public-profile-url,site-standard-profile-request)';
                    $signatureMethod = new OAuthSignatureMethod_HMAC_SHA1();
                    $options = array();
                    $query = null;
                    $request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $url, $query);
                    $request->sign_request($signatureMethod, $consumer, $token);
                    $answer = self::makeRequest($request->to_url(), $options, false);

                    if(strpos($answer, 'error:') === false){
                        
                        $socUser = self::xmlToArray(simplexml_load_string($answer));
                        $spotContent=SpotContent::getSpotContent($spot);
                        if($spotContent){
                            $content=$spotContent->content;
                            $result = Yii::t('eauth', "Для LinkedIn Вы можете привязать только свой профиль");

                            if(!empty($socUser['public-profile-url']) && isset($content['data']) && isset($content['data'][$dataKey])){
                                $profileUrl = urldecode($socUser['public-profile-url']);
                                if(strpos($profileUrl, 'linkedin.com/') !== false)
                                    $profileUrl = substr($profileUrl, (strpos($profileUrl, 'linkedin.com/')+13));
                                if(strpos($profileUrl, '&') > 0)
                                    $profileUrl = substr($profileUrl, 0, strpos($profileUrl, '&'));
                                if(strpos($content['data'][$dataKey], $profileUrl) !== false)
                                    $result = 'ok';
                            }
                            if(!empty($socUser['site-standard-profile-request']) && !empty($socUser['site-standard-profile-request']['url']) && isset($content['data']) && isset($content['data'][$dataKey])){
                                $profileUrl = urldecode($socUser['site-standard-profile-request']['url']);
                                if(strpos($profileUrl, 'linkedin.com/') !== false)
                                    $profileUrl = substr($profileUrl, (strpos($profileUrl, 'linkedin.com/')+13));
                                if(strpos($profileUrl, '&') > 0)
                                    $profileUrl = substr($profileUrl, 0, strpos($profileUrl, '&'));
                                if(strpos($content['data'][$dataKey], $profileUrl) !== false)
                                    $result = 'ok';
                            }
                        }
                    }
                }
            }
        }
        
        return $result;
    }

    public static function parseUsername($link)
    {
        return $link;
    }
    
    protected function xmlToArray($element) 
    {
        $array = (array)$element;
        foreach ($array as $key => $value) {
            if (is_object($value))
                $array[$key] = self::xmlToArray($value);
        }
        return $array;
   }
}