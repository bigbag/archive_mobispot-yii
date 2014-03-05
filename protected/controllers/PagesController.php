<?php

class PagesController extends MController
{

    public function actionDevices()
    {
        $this->layout = '//layouts/all';
        $this->render('devices', array('phones' => Phone::getJsonPhones(), 'devices' => Phone::getJsonDevices()));
    }

    public function actionHelp()
    {
        $this->layout = '//layouts/all';
        $this->render('help', array());
    }
}