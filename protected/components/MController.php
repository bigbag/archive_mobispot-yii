<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MController extends Controller
{

    const MIN_RESOLUTION = 1280;

    const URL_PATTERN = '{(https?://)?(www\.)?([a-zA-Z0-9_.\-%]*)\b\.[a-z]{2,4}(\.[a-z]{2})?((/[a-zA-Z0-9_%?=]*)+)?([^\]\s]*)?}xis';
    const MOBILE_PLATFORM_PATTERN = '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i';
    const MOBILE_VERSION_PATTERN = '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i';

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
            self::URL_PATTERN, 'MController::hrefCallback', $text
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
            self::URL_PATTERN, 'MController::urlCallback', $text
        );
    }

    public function getResolution()
    {
        $resolution = $this->defaultResolution;
        if (isset(Yii::app()->request->cookies['resolution'])) {
            $resolution = Yii::app()->request->cookies['resolution']->value;
            if ($resolution < self::MIN_RESOLUTION) $resolution = self::MIN_RESOLUTION;

        }
        return $resolution;
    }

    public function getBaseUrl()
    {
        return Yii::app()->request->getBaseUrl(true);
    }


    public function init()
    {
        Lang::setCurrentLang();
    }

    public function desktopHost($protocol = 'http')
    {
        return $protocol . '://' . str_replace("m.", ' ', $_SERVER['SERVER_NAME']);
    }

    public function request_url()
    {
        $answer = 'http://';
        $default_port = 80;

        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
            $answer .= 'https://';
            $default_port = 443;
        }

        $answer .= $_SERVER['SERVER_NAME'];

        if ($_SERVER['SERVER_PORT'] != $default_port) {
            $answer .= ':'.$_SERVER['SERVER_PORT'];
        }

        $answer .= $_SERVER['REQUEST_URI'];

        return $answer;
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
}
