<?php

class WalletController extends MController
{
  public $layout='//layouts/payment';

  public function actionIndex()
  {
    if(!Yii::app()->user->isGuest){
      $wallets=PaymentWallet::model()->selectUser(Yii::app()->user->id)->findAll();

      $this->render('index', array(
          'wallets'=>$wallets,
      ));
    }
    else {
      $this->setAccess();
    }
  }

  // Формирование платежа
  public function actionAddSumm() {
  if (Yii::app()->request->isPostRequest) {
    $error="yes";
    $order=array();

    $data=$this->getJson();
    if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
      if (isset($data['summ'])) {
        $summ=(int)$data['summ'];

        $uni = new Uniteller;
        $order['idShop'] = $uni->getShopId();
        $order['idCustomer'] = 1;
        $order['idOrder'] = time();
        $order['subtotal'] = $data['summ'];
        $order['signature'] = $uni->signOrder($order);
        $order['return_ok'] = $this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=success';
        $order['return_error'] = $this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=error';
        $error="no";
      }
    }
      echo json_encode(array('error'=>$error, 'order'=>$order));
    }
  }
}