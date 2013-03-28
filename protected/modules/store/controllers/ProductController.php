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
		$data = Cart::getPriceList();
		header('Content-Type: application/json; charset=UTF-8');
		echo CJSON::encode($data);
		Yii::app()->end();		
	}
	
	public function actionGetCart(){
		$cart = new Cart;
		$data = array();
		$data['products'] = $cart->getStoreCart();
		$data['delivery'] = $cart->getDelivery();
		$data['payment'] = $cart->getPayment();
		header('Content-Type: application/json; charset=UTF-8');
		echo CJSON::encode($data);
		Yii::app()->end();		
	}
	
	public function actionGetCustomer(){
		$cart = new Cart;
		$data = $cart->getCustomer();
		header('Content-Type: application/json; charset=UTF-8');
		echo CJSON::encode($data);
		Yii::app()->end();		
	}
	
	public function actionAddToCart(){
		$answer = array();
		$answer['stat'] = '-1';
		$answer['error'] = 'Не получены данные товара!';
		$data = file_get_contents("php://input");
		if(isset($data)){
			$newProduct = json_decode($data);
			$cart = new Cart;
			if($cart->addToCart($newProduct)){
				$answer['stat'] = 'ok';
				$answer['error'] = '0';			
			}
		}
		header('Content-Type: application/json; charset=UTF-8');
		echo CJSON::encode($answer);
		Yii::app()->end();	
	}	
	
	public function actionDeleteFromCart(){
		$answer = array();
		$answer['stat'] = '-1';
		$data = file_get_contents("php://input");
		if(isset($data)){
			$deleted = json_decode($data);
			$cart = new Cart;
			if($cart->deleteFromCart($deleted)){
				$answer['stat'] = 'ok';		
			}
		}
		header('Content-Type: application/json; charset=UTF-8');
		echo CJSON::encode($answer);
		Yii::app()->end();		
	}
	
	public function actionSaveCustomer(){
		$answer = array();
		$answer['stat'] = '-1';
		$answer['error'] = 'Не заполнены требуемые поля';
		$data = file_get_contents("php://input");
		if(isset($data)){
			$decoded = json_decode($data);
			$cart = new Cart;

			if($cart->saveCustomer($decoded->customer)){
				$answer['stat'] = 'ok';
			}

		}
		header('Content-Type: application/json; charset=UTF-8');
		echo CJSON::encode($answer);
		Yii::app()->end();	
	}	
}
