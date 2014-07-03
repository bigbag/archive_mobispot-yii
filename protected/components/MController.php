<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class MController extends CController
{
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
}
