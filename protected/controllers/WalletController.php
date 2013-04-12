<?php

class WalletController extends MController {

	public $layout = '//layouts/all';

	public function actionIndex() {
		if(!Yii::app()->user->isGuest){
			$message = '';
			if(isset($_GET['oper_result']) && isset($_GET['Order_ID'])){
				if($_GET['oper_result']){
					$wal = Wallet::model()->findByAttributes(array(
						'id_user'=>Yii::app()->user->id
					));
					
					if($wal){
						$hist = History::model()->findByAttributes(array(
							'id_wallet'=>$wal->id,
							'id'=>$_GET['Order_ID'],
							'status'=>1
						));
						
						if($hist){
							$uni = new Uniteller;
							$dat = $uni->getData($hist->id);
							if ($dat['Status'] == 'Authorized'){
								$wal->balance += $hist->summ;
								$hist->status = 3;
								$model=Wallet::model();
								$transaction=$model->dbConnection->beginTransaction();
								try
								{
									$wal->save();
									$hist->save();
									$transaction->commit();
									$message = 'Выполнено пополнение средств на кошельке!';
								}
								catch(Exception $e)
								{
									$transaction->rollback();
								}
							}
						}
					}
				}else
					$message = 'Не удалось провести платеж!';
			}
			$this->render('index', array('message'=>$message));
		}
	}
	
	public function actionGetWallet(){
		if (Yii::app()->request->isPostRequest) {
			$answer = array();
			$data = $this->getJson();
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken and (!Yii::app()->user->isGuest)) {
				$wal = Wallet::model()->findByAttributes(array(
						'id_user'=>Yii::app()->user->id
					));
					
				if($wal){
					$wal->balance = (float)$wal->balance/100;
					$hist = History::model()->findAllByAttributes(array(
						'id_wallet'=>$wal->id,
						'status'=>3
					));
					$size = count($hist);
					for ($i = 0; $i < $size; $i++) {
						$hist[$i]->summ = (float)$hist[$i]->summ/100;
						$hist[$i]->oper_date = date('d.m.Y H:i:s', strtotime($hist[$i]->oper_date));
						$hist[$i]->oper_type = ($hist[$i]->oper_type == 0) ? '-' : '+';
					}
					$answer['history'] = $hist;
				}else{
					$wal = array();
					$wal['balance'] = 0;
				}
				
				$answer['wallet'] = $wal;				
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($answer);			
		}
		Yii::app()->end();
	}
	
	public function actionGetUnitellerOrder(){
		if (Yii::app()->request->isPostRequest) {
			$answer = array();
			$data = $this->getJson();	
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken and (!Yii::app()->user->isGuest) and isset($data['newSumm'])) {
				
				$newSumm = preg_replace('~[юЮбБ,?/]+~', '.', $data['newSumm']);
				if (preg_match("~^[0-9]{1,10}[.,]{0,1}[0-9]{0,2}$~", $newSumm)){
					$wal = Wallet::model()->findByAttributes(array(
							'id_user'=>Yii::app()->user->id
						));
					if(!$wal){
						$wal = new Wallet;
						$wal->id_user = Yii::app()->user->id;
						$wal->balance = 0;
						$wal->save();
					}
						
					$hist = History::model()->findByAttributes(array(
							'id_wallet'=>$wal->id,
							'oper_type'=>1,
							'summ'=>$newSumm*100,
							'status'=>0,
						));
						
					if(!$hist){
						$hist = new History;
						$hist->id_wallet = $wal->id;	
						$hist->oper_type = 1;	
					}
					
					$hist->oper_date = date("Y-m-d H:i:s");
					$hist->summ = $newSumm*100;
					$hist->description = 'Пополнение через Uniteller';
					$hist->status = 1;
					$hist->save();
					
					$order = array();
					$uni = new Uniteller;
					$order['idShop'] = $uni->getShopId();
					$order['idCustomer'] = $wal->id;
					$order['idOrder'] = $hist->id;
					$order['subtotal'] = $newSumm;
					$order['signature'] = $uni->signOrder($order);
					$order['return_ok'] = $this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=success';
					$order['return_error'] = $this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=error';
					
					$answer['order'] = $order;
				}
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($answer);	
		}
		Yii::app()->end();
	}
	


}