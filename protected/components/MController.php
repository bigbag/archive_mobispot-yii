<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MController extends Controller
{

    const MIN_RESOLUTION = 1280;

    public $mainBackground = false;
    public $defaultResolution = 1280;

    public $blockHeaderCeo = false;
    public $blockFooterScript = false;

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/all';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();


    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function beforeRender()
    {
        //Yii::app()->cache->flush();
        return true;
    }

    public function userInfo()
    {
        if (Yii::app()->user->id)
        {
            $id = Yii::app()->user->id;
            $info = Yii::app()->cache->get('user_' . $id);
            if ($info == false)
            {
                $info = UserProfile::model()->findByPk($id);
                $user = User::model()->findByPk($id);
                if (empty($info->name))
                    $info->name = $user->email;

                Yii::app()->cache->set('user_' . $id, $info, 3600);
            }

            return $info;
        }
        else
            return false;
    }

    public function lastVisit()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user)
        {
            $user->lastvisit = date('Y-m-d H:i:s');
            if ($user->save(false))
                return true;
        }
        return false;
    }

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
        if (!Yii::app()->request->isPostRequest) $this->setBadRequest();

        $data = $this->getJson();
        if (!isset($data['token']) or $data['token'] != Yii::app()->request->csrfToken)
            $this->setBadRequest();

        unset($data['token']);
        return $data;
    }

    public function getLang()
    {
        return (Yii::app()->request->cookies['lang']) ? Yii::app()->request->cookies['lang']->value : 'en';
    }

    public function getJson()
    {
        $post = file_get_contents("php://input");
        return CJSON::decode($post, true);
    }

    public function getJsonAndExit($result){
        echo json_encode($result);
        exit;
    }

    public function getJsonOrRedirect($result, $target){
        if (Yii::app()->request->isPostRequest)
            $this->getJsonAndExit($result);
        else
            $this->redirect($target);
    }

    public function getCart()
    {
        if (Yii::app()->session['itemsInCart'] and Yii::app()->session['itemsInCart'] > 0)
            return Yii::app()->session['itemsInCart'];
        else
            return false;
    }

    // Функция обратного вызова для preg_replace_callback().
    public function hrefCallback($p)
    {
        $name = htmlspecialchars($p[0]);
        $href = !empty($p[1]) ? $name : "http://$name";
        return "<a href=\"$href\">$name</a>";
    }

    // Заменяет ссылки на их HTML-эквиваленты ("подчеркивает ссылки").
    public function hrefActivate($text)
    {
        return preg_replace_callback(
                '{(https?://)?(www\.)?([a-zA-Z0-9_.\-%]*)\b\.[a-z]{2,4}(\.[a-z]{2})?((/[a-zA-Z0-9_%?=]*)+)?([^\]\s]*)?}xis', 'MController::hrefCallback', $text
        );
    }

    public function urlCallback($p)
    {
        $name = htmlspecialchars($p[0]);
        $href = !empty($p[1]) ? $name : "http://$name";
        return $href;
    }

    public function urlActivate($text)
    {
        return preg_replace_callback(
                '{(https?://)?(www\.)?([a-zA-Z0-9_.\-%]*)\b\.[a-z]{2,4}(\.[a-z]{2})?((/[a-zA-Z0-9_%?=]*)+)?([^\]\s]*)?}xis', 'MController::urlCallback', $text
        );
    }

    public function getResolution()
    {
        $resolution = $this->defaultResolution;
        if (isset(Yii::app()->request->cookies['resolution']))
        {
            $resolution = Yii::app()->request->cookies['resolution']->value;
            if ($resolution < self::MIN_RESOLUTION) $resolution = self::MIN_RESOLUTION;

        }
        return $resolution;
    }

    public function setCurlRequest($url, $data=false) {
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
        else return $errno;
    }

    public function init()
    {
        $all_lang = Lang::getLangArray();
        $select_lang = 'en';

        if (isset(Yii::app()->request->cookies['lang']))
        {
            $select_lang = Yii::app()->request->cookies['lang']->value;
        }
        elseif (Yii::app()->user->id)
        {
            $user = User::getById(Yii::app()->user->id);
            $select_lang = $user->lang;
        }
        else
        {
            $lang_request = Yii::app()->getRequest()->getPreferredLanguage();
            $select_lang = substr($lang_request,0,1);
        }

        if (!isset($all_lang[$select_lang])) $select_lang = 'ru';

        Yii::app()->request->cookies['lang'] = new CHttpCookie('lang', $select_lang);
        Yii::app()->language = $select_lang;
    }

}
