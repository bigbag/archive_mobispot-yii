<?php
class MHttp
{
    const TYPE_GET = 'GET';
    const TYPE_POST = 'POST';
    
    public static function setAccess()
    {
        if (!Yii::app()->request->isPostRequest)
            Yii::app()->session['access_url'] = Yii::app()->request->requestUri;

        throw new CHttpException(403, Yii::t('user', 'Forbidden.'));
    }

    public static function setNotFound()
    {
        throw new CHttpException(404, Yii::t('user', 'The requested page does not exist.'));
    }

    public static function setBadRequest()
    {
        throw new CHttpException(400, Yii::t('user', 'Bad Request'));
    }

    public static function validateRequest()
    {
        if (!Yii::app()->request->isPostRequest) self::setBadRequest();

        $data = self::getJson();
        if (!isset($data['token']) or $data['token'] != Yii::app()->request->csrfToken)
            self::setBadRequest();

        unset($data['token']);
        return $data;
    }

    public static function getJson()
    {
        $post = file_get_contents("php://input");
        return CJSON::decode($post, true);
    }

    public static function getJsonAndExit($result)
    {
        echo json_encode($result);
        exit;
    }

    public static function getJsonOrRedirect($result, $target)
    {
        if (Yii::app()->request->isPostRequest) self::getJsonAndExit($result);
        else Yii::app()->controller->redirect($target);
    }

    public static function setCurlRequest($url, $type=self::TYPE_GET, $params=array(), $autorization=false, $headers=false, $data=array())
    {
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, (string)$url . self::toGetParams($params));
        
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        
        if (!empty($autorization) and !empty($autorization['login']) 
            and !empty($autorization['password'])) {
                
            curl_setopt($ch, CURLOPT_USERPWD, 
                $autorization['login']
                . ':' 
                . $autorization['password']);
                
            if (!empty($autorization['method']))
                curl_setopt($ch, CURLOPT_HTTPAUTH, $autorization['method']);
            else
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        }
        
        if (!empty($headers) and is_array($headers))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        
        if (self::TYPE_POST == $type) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data)?$params:(array)$data);
        } 

        $result=curl_exec($ch);
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        curl_close($ch);

        if ($errno == 0) return $result;
        else {
            return '{error: ' . $errno . '}';
        }
    }

    public static function toGetParams($data, $prefix = '?')
    {
        $params = '';
        
        if (!is_array($data))
            return $params;
        
        foreach($data as $key=>$value)
            $params .= '&' . $key . '=' . $value;
        
        if (strlen($params))
            $params = $prefix . substr($params, 1);

        return $params;
    }
    
    public static function isMobileUserAgent()
    {
        $detect = Yii::app()->mobileDetect;
        return $detect->isMobile();
    }

    public function isHostMobile()
    {
        $answer = false;
        if(empty(Yii::app()->params['mobileHost'])) {
            if (strpos($_SERVER['HTTP_HOST'], 'm.') !== false)
                $answer = true;
        } else {
            if ($_SERVER['HTTP_HOST'] == Yii::app()->params['mobileHost'])
                $answer = true;
        }

        return $answer;
    }

    public static function desktopHost()
    {
        $host = $_SERVER['HTTP_HOST'];
        if (!empty(Yii::app()->params['desktopHost']))
            $host = '//' . Yii::app()->params['desktopHost'];
        else
            $host = '//' . str_replace("m.", '', $host);
        return $host;
    }
}
