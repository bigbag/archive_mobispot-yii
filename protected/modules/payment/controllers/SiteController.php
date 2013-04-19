<?php

class SiteController extends MController
{
  public function actionIndex()
  {
    $this->layout='//layouts/payment';
    $this->render('index');
  }
}