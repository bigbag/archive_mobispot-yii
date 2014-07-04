<?php
class MHttp
{
    const MOBILE_PLATFORM_PATTERN = '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i';
    const MOBILE_VERSION_PATTERN = '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i';

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

    public function isMobile()
    {
        $answer = false;
        $useragent=$_SERVER['HTTP_USER_AGENT'];

        $check_platform = preg_match(self::MOBILE_PLATFORM_PATTERN,$useragent);
        $check_version = preg_match(self::MOBILE_VERSION_PATTERN,substr($useragent,0,4));
        if ($check_platform or $check_version) $answer = true;

        return $answer;
    }

    public function desktopHost($protocol = 'http')
    {
        $host = $_SERVER['HTTP_HOST'];
        if (!empty(Yii::app()->params['desctop_host']))
            $host = $protocol . '://' . Yii::app()->params['desctop_host'];
        else
            $host = $protocol . '://' . str_replace("m.", '', $host);
        return $host;
    }
}