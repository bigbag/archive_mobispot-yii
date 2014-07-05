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
