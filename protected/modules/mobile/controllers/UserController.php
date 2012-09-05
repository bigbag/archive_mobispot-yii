<?php

class UserController extends MController
{
    public $layout = '//layouts/mobile';

    public function actionIndex()
    {
        $this->render('index', array(
        ));
    }
}