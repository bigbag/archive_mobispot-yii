<?php
class MHttp
{
    public function setAccess()
    {
        throw new CHttpException(403, Yii::t('user', 'Forbidden.'));
    }

    public function setNotFound()
    {
        throw new CHttpException(404, Yii::t('user', 'The requested page does not exist.'));
    }

    public function setBadRequest()
    {
        throw new CHttpException(400, Yii::t('user', 'Bad Request'));
    }

    public function validateRequest()
    {
        if (!Yii::app()->request->isPostRequest) self::setBadRequest();

        $data = self::getJson();
        if (!isset($data['token']) or $data['token'] != Yii::app()->request->csrfToken)
            self::setBadRequest();

        unset($data['token']);
        return $data;
    }

    public function getJson()
    {
        $post = file_get_contents("php://input");
        return CJSON::decode($post, true);
    }

    public function getJsonAndExit($result)
    {
        echo json_encode($result);
        exit;
    }

    public function getJsonOrRedirect($result, $target)
    {
        if (Yii::app()->request->isPostRequest) self::getJsonAndExit($result);
        else $this->redirect($target);
    }

    public function setCurlRequest($url, $data=false)
    {
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, (string)$url);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, (array)$data);
        }
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        $result=curl_exec($ch);
        $errno=curl_errno($ch);
        $error=curl_error($ch);
        curl_close($ch);

        if ($errno == 0) return $result;
        else {
            return '{error: ' . $errno . '}';
        }
    }

}