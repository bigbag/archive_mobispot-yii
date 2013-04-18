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

        $history=new PaymentHistory;
        $history->user_id=Yii::app()->user->id;
        $history->wallet_id=$data['wallet'];
        $history->summ=$data['summ'];

        if ($history->save()){
          $payment=new Uniteller;
          $order['idShop']=$payment->getShopId();
          $order['idCustomer']=$data['wallet'];
          $order['idOrder']=$history->id;
          $order['subtotal']=$data['summ'];
          $order['signature']=$payment->signOrder($order);
          $order['return_ok']=$this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=success';
          $token=sha1(Yii::app()->request->csrfToken);
          $order['return_error']=$this->createAbsoluteUrl('/payment/wallet/cancelOrder').'?token='.$token;
          $error="no";
        }
      }
    }
      echo json_encode(array('error'=>$error, 'order'=>$order));
    }
  }

  // Отмена платежа
  public function actionCancelOrder() {
    if (!Yii::app()->user->isGuest){
      $token=Yii::app()->request->getParam('token', 0);
      $id=Yii::app()->request->getParam('Order_ID', 0);

      if ($id and $token and $token==sha1(Yii::app()->request->csrfToken)){
        $history=PaymentHistory::model()->findByPk((int)$id);

        if ($history){
          $history->status=PaymentHistory::STATUS_FAILURE;
          $history->save();
        }
      }
    }
    #Yii::app()->request->redirect('/payment/wallet/');
  }
}