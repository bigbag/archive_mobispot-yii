<?php

class WalletController extends MController
{
  public $layout='//layouts/payment';

  public function actionIndex()
  {
    if(!Yii::app()->user->isGuest){
      $wallets=PaymentWallet::model()->selectUser(Yii::app()->user->id)->findAll();
      $history=PaymentHistory::model()->complete()->selectUser(Yii::app()->user->id);

      $this->render('index', array(
          'wallets'=>$wallets,
          'history'=>$history,
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
          $token=sha1(Yii::app()->request->csrfToken);
          $order['return_ok']=$this->createAbsoluteUrl('/payment/wallet/setResult').'?result=success&token='.$token;
          $order['return_error']=$this->createAbsoluteUrl('/payment/wallet/setResult').'?result=error&token='.$token;
          $error="no";
        }
      }
    }
      echo json_encode(array('error'=>$error, 'order'=>$order));
    }
  }

  // Обработка ответа о платеже
  public function actionSetResult() {
    if (!Yii::app()->user->isGuest){
      $token=Yii::app()->request->getParam('token', 0);
      $id=Yii::app()->request->getParam('Order_ID', 0);
      $result=Yii::app()->request->getParam('result', 0);

      if ($result and $id and $token and $token==sha1(Yii::app()->request->csrfToken)){
        $history=PaymentHistory::model()->findByPk((int)$id);

        if ($history){
          if ($result=='error'){
            $history->status=PaymentHistory::STATUS_FAILURE;
            $history->save(false);
          }
          else if ($result=='success'){
            $history->status=PaymentHistory::STATUS_COMPLETE;
            $wallet=PaymentWallet::model()->findByPk($history->wallet_id);
            if ($wallet){
              $wallet->balance=$wallet->balance+$history->summ;
              if ($wallet->save(false)){
                $history->type=PaymentHistory::TYPE_PLUS;
                $history->desc='Пополнение через Uniteller';
                $history->save(false);
              }
            }
          }
        }
      }
    }
    Yii::app()->request->redirect('/payment/wallet/');
  }
}