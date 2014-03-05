<?php

class PagesController extends MController
{

    public function actionReaders()
    {
        $this->layout = '//layouts/all';
        $this->render('readers', array('phones' => Phone::getJsonPhones(), 'devices' => Phone::getJsonDevices()));
    }

    public function actionHelp()
    {
        $this->layout = '//layouts/all';
        $this->render('help', array());
    }
}