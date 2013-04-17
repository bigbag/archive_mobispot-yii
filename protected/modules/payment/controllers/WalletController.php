<?php

class WalletController extends MController
{
  public $layout='//layouts/payment';

  public function actionIndex()
  {
    if(!Yii::app()->user->isGuest){
      $this->render('index');
    }
    else {
      $this->setAccess();
    }
  }
}