<?php

class WalletController extends MController {

	public $layout = '//layouts/all';

	public function actionIndex() {
		if(!Yii::app()->user->isGuest){
			$message = '';
			if(isset($_POST['oper_result']) && isset($_POST['Order_ID'])){
				$message ='получены параметры';
				if($_POST['oper_result']){
					$wal = Wallet::model()->findByAttributes(array(
						'id_user'=>Yii::app()->user->id
					));
					
					if($wal){
						$hist = History::model()->findAllByAttributes(array(
							'id_wallet'=>$wal->id,
							'id'=>$_POST['Order_ID'],
							'status'=>0
						));
						
						if($hist){
							$dat = $this->getData($hist->id);
							$message = print_r($dat, true);
							//$message = 'Выполнено пополнение средств на кошельке!';
						}
					}
				}else
					$message = 'Не удалось провести платеж!';
			}
			$this->render('index', array('message'=>$message));
		}
	}
	
	public function actionGetWallet(){
		if (Yii::app()->request->isAjaxRequest) {
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
						'status'=>1
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
		if (Yii::app()->request->isAjaxRequest) {
			$answer = array();
			$data = $this->getJson();	
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken and (!Yii::app()->user->isGuest) and isset($data['newSumm']) and ((float)$data['newSumm'] > 0)) {
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
						'summ'=>$data['newSumm']*100,
						'status'=>0,
					));
					
				if(!$hist){
					$hist = new History;
					$hist->id_wallet = $wal->id;	
					$hist->oper_type = 1;	
				}
				
				$hist->oper_date = date("Y-m-d H:i:s");
				$hist->summ = $data['newSumm']*100;
				$hist->description = 'Пополнение через Uniteller';
				$hist->status = 0;
				$hist->save();
				
				$order = array();
				$order['idShop'] = '7208758777-2667';
				$order['idCustomer'] = $wal->id;
				$order['idOrder'] = $hist->id;
				$order['subtotal'] = $data['newSumm'];
				$order['signature'] = strtoupper(
					md5(
					md5($order['idShop']) . "&" .
					md5($order['idOrder']) . "&" .
					md5($order['subtotal']) . "&" .
					md5('') . "&" .			//$MeanType
					md5('') . "&" .			//$EMoneyType
					md5('') . "&" .			//$Lifetime
					md5($order['idCustomer']) . "&" .
					md5('') . "&" .			//$Card_IDP
					md5('') . "&" .			//$IData
					md5('') . "&" .			//$PT_Code
					md5('PgJhDRtqXcDDSsYATWN5yuKlQKnEI0zU7JPY3hjKmNr5EETDMwBZQKy8VT1us7lOgGDeMUuHlG4qILxM')			
					)
				);
				$order['return_ok'] = $this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=success';
				$order['return_error'] = $this->createAbsoluteUrl('Wallet/index').'/wallet?oper_result=error';
				
				$answer['order'] = $order;
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($answer);	
		}
		Yii::app()->end();
	}
	
	private function getData($Order_ID) {
		// Параметры могут извлекаться из БД или из других хранилищ данных, либо содержаться внутри кода
		$Shop_ID = "7208758777-2667"; // идентификатор точки продажи
		$Login = 1629; // логин из ЛК Uniteller
		$Password = "PgJhDRtqXcDDSsYATWN5yuKlQKnEI0zU7JPY3hjKmNr5EETDMwBZQKy8VT1us7lOgGDeMUuHlG4qILxM"; // пароль из ЛК Uniteller
		/* Format=1 - получить данные в виде строки с разделителем ";", можно получать
		данные и в других форматах (см. Технический порядок), например, XML, тогда обработка
		полученного ответа изменится*/
		$sPostFields =
		"Shop_ID=".$Shop_ID."&Login=".$Login."&Password=".$Password."&Format=1&ShopOrderNumber=".
		$Order_ID."&S_FIELDS=Status;ApprovalCode;BillNumber";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://test.wpay.uniteller.ru/results/");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sPostFields);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
		$curl_response = curl_exec($ch);
		$curl_error = curl_error($ch);
		$data = array(); // результат для возврата
		if ($curl_error) {
			// обработка ошибки обращения за статусом платежа
		} else {
			// данные получены
			// обработка данных из переменной $curl_response
			$arr = explode( ";", $curl_response );
			if ( count($arr) > 2 ) {
				$data = array(
					"Status" => $arr[0]
					, "ApprovalCode" => $arr[1]
					, "BillNumber"
					=> $arr[2]
				);
			} else {
				// что-то не так, обработчик полученного ответа
			}
		}
		return $data;
		
	}
	
	private function checkSignature( $Order_ID, $Status, $Signature ) {
		$password = "PgJhDRtqXcDDSsYATWN5yuKlQKnEI0zU7JPY3hjKmNr5EETDMwBZQKy8VT1us7lOgGDeMUuHlG4qILxM"; // пароль из ЛК Uniteller
		// проверка подлинности подписи и данных
		return ( $Signature == strtoupper(md5($Order_ID . $Status . $password)) );
	}

}