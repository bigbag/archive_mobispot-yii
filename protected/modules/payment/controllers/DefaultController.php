<?php

class DefaultController extends MController
{
  public $layout='//layouts/payment';

  public function actionIndex()
  {
    $this->render('index');
  }
}