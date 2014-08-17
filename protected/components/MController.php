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

    public function beforeRender($action)
    {
        //Yii::app()->cache->flush();

        $full_view = false;
        if (isset(Yii::app()->request->cookies['full_view'])){
            $full_view = Yii::app()->request->cookies['full_view']->value;
        }

        if (MHttp::isMobileUserAgent() and !MHttp::isHostMobile() and !$full_view){
             $this->redirect('//' . Yii::app()->params['mobileHost']);
        }
        return parent::beforeRender($action);
    }

    public function getBaseUrl()
    {
        return Yii::app()->request->getBaseUrl(true);
    }


    public function init()
    {
        Lang::setCurrentLang();
    }

    public function renderWithMobile($view, $data, $viewMobile = false, $dataMobile = false)
    {
        if (!MHttp::isHostMobile())
            $this->render($view, $data);
        else {
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

        if (!MHttp::isHostMobile())
            $answer = $this->renderPartial($view, $data, $return);
        else {
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
