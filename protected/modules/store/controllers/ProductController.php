<?php

class ProductController extends MController {

	public $layout = '//layouts/all';

	public function actionIndex() {
		$this->render('index');
	}

	public function actionCart() {
		$this->render('cart');
	}	
	
	public function actionGetPriceList(){
		//if (Yii::app()->request->isAjaxRequest) {
			$cart = new Cart;
			$data['products'] = $cart->getPriceList();
			if(isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0))
				$data['itemsInCart'] = Yii::app()->session['itemsInCart'];
			else
				$data['itemsInCart'] = 0;
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($data);
			Yii::app()->end();		
		//}
	}
	
	public function actionGetCart(){
		if (Yii::app()->request->isAjaxRequest) {
			$data = $this->getJson();
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
				$cart = new Cart;
				$data = array();
				$data['products'] = $cart->getStoreCart();
				header('Content-Type: application/json; charset=UTF-8');
				echo CJSON::encode($data);
				Yii::app()->end();		
			}
		}
	}
	
	public function actionGetCustomer(){
		if (Yii::app()->request->isAjaxRequest) {
			$data = $this->getJson();
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
				$cart = new Cart;
				$data['customer'] = $cart->getCustomer();
				$data['delivery'] = $cart->getDelivery();
				$data['payment'] = $cart->getPayment();
				header('Content-Type: application/json; charset=UTF-8');
				echo CJSON::encode($data);
				Yii::app()->end();		
			}
		}
	}
	
	public function actionAddToCart(){
		if (Yii::app()->request->isAjaxRequest) {
			$answer = array();
			$answer['error'] = 'Не получены данные товара!';
			$data = $this->getJson();
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
				$cart = new Cart;
				if($cart->addToCart($data)){
					$answer['error'] = 'no';			
				}
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($answer);
			Yii::app()->end();	
		}
	}	
	
	public function actionDeleteFromCart(){
		if (Yii::app()->request->isAjaxRequest) {
			$answer = array();
			$answer['error'] = '-1';
			$data = $this->getJson();
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
				$cart = new Cart;
				if($cart->deleteFromCart($data)){
					$answer['error'] = 'no';		
				}
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($answer);
			Yii::app()->end();		
		}
	}
	
	public function actionSaveCustomer(){
		if (Yii::app()->request->isAjaxRequest) {
			$answer = array();
			$answer['error'] = 'Не заполнены требуемые поля';
			$data = $this->getJson();
			if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
				$cart = new Cart;
				if($cart->saveCustomer($data['customer'])){
					$answer['error'] = 'no';
				}
			}
			header('Content-Type: application/json; charset=UTF-8');
			echo CJSON::encode($answer);
			Yii::app()->end();	
		}
	}

	public function actionGetItemsInCart(){
		//if (Yii::app()->request->isAjaxRequest) {
		//	$data = $this->getJson();
		//	if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
				$answer = array();
				$cart = new Cart;
				if(isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0))
					$answer['itemsInCart'] = Yii::app()->session['itemsInCart'];
				else			
					$answer['itemsInCart'] = 0;
				header('Content-Type: application/json; charset=UTF-8');
				echo CJSON::encode($answer);
		//	}
		//}
		Yii::app()->end();
	}
}
