<?php

class PagesController extends MController
{

    public function actionPhones()
    {
        $this->layout = '//layouts/all';
        $this->render('phones', array());
    }

    public function actionHelp()
    {
        $this->layout = '//layouts/all';
        $this->render('help', array());
    }
}