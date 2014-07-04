<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MController extends CController
{
    const MOBILE_LAYOUT = '//layouts/mobile';
    public $mainBackground = false;
    public $blockHeaderCeo = false;
    public $blockFooterScript = false;

    public $layout = '//layouts/all';
    public $menu = array();
    public $breadcrumbs = array();

    public function beforeRender()
    {
        //Yii::app()->cache->flush();
        return true;
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
        $host = $_SERVER['HTTP_HOST'];
        if (!empty(Yii::app()->params['desctop_host']))
            $host = $protocol . '://' . Yii::app()->params['desctop_host'];
        else
            $host = $protocol . '://' . str_replace("m.", '', $host);
        return $host;
    }

    public function request_url()
    {
        $answer = 'http://';
        $default_port = 80;

        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=='on')) {
            $answer .= 'https://';
            $default_port = 443;
        }

        $answer .= $_SERVER['HTTP_HOST'];

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
    
    public function isHostMobile()
    {
        $answer = false;
        if (!empty(Yii::app()->params['mobile_host']) and $_SERVER['HTTP_HOST'] == Yii::app()->params['mobile_host'])
            $answer = true;
        elseif(empty(Yii::app()->params['mobile_host']) 
            and (strpos($_SERVER['HTTP_HOST'], 'm.') !== false))
            $answer = true;
    
        return $answer;
    }
    
    public function renderWithMobile($view, $data, $viewMobile = false, $dataMobile = false)
    {
        if (!$this->isHostMobile())
            $this->render($view, $data);
        else
        {
            if (!$viewMobile)
                $viewMobile = '/mobile/' . $this->getUniqueId() . '/' . $view;
            if (!$dataMobile)
                $dataMobile = $data;
                
            $this->layout = self::MOBILE_LAYOUT;
            $this->render($viewMobile, $data);
        }
    }
    
    public function renderPartialWithMobile($view, $data, $return, $viewMobile = false, $dataMobile = false)
    {
        $answer = false;
        
        if (!$this->isHostMobile())
            $answer = $this->renderPartial($view, $data, $return);
        else
        {
            if (!$viewMobile)
                $viewMobile = '/mobile/' . $this->getUniqueId() . '/' . $view;
            if (!$dataMobile)
                $dataMobile = $data;
                
            $answer = $this->renderPartial($viewMobile, $dataMobile, $return);
        }
        
        if ($return)
            return $answer;
    }
}
