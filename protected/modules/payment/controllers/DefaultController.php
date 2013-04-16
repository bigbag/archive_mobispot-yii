<?php

class DefaultController extends MController
{
  public $layout='//layouts/all';

  public function actionIndex()
  {
    $this->render('index');
  }
}