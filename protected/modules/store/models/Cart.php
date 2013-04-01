<?php

class Cart extends CFormModel
{
	protected $storeCart = array();
	
	public function __construct(){
		if(isset(Yii::app()->session['storeCart'])){
			$this->storeCart = Yii::app()->session['storeCart'];
		}else{
			if (!Yii::app()->user->isGuest){
				$user_id = Yii::app()->user->id;
				$user = User::model()->findByPk($user_id);
				if($user)
					Yii::app()->session['storeEmail'] = $user->email;
				
				$dbCustomer = Customer::model()->findByAttributes(array(
					'email'=>$user->email
				));
			}elseif(isset(Yii::app()->session['storeEmail'])){
					$dbCustomer = Customer::model()->findByAttributes(array(
						'email'=>Yii::app()->session['storeEmail']
				));
			}

			if(isset($dbCustomer) && ($dbCustomer)) {
				$order = StoreOrder::model()->findByAttributes(array(
					'id_customer'=>$dbCustomer->id,
					'status'=>0
				));
				if($order){
					$list = OrderList::model()->findAllByAttributes(array(
						'id_order'=>$order->id
					));
					if($list){
						foreach($list as $item){
							$product = array();
							$selectedSize = array();
							$product['id'] = $item->id_product;
							$product['quantity'] = $item->quantity;
							$product['selectedColor'] = $item->color;
							$selectedSize['value'] = $item->size_name;
							$selectedSize['price'] = $item->price;
							$product['selectedSize'] = $selectedSize;						
							$this->storeCart[] = $product;
						}
						Yii::app()->session['storeCart'] = $this->storeCart;
						Yii::app()->session['itemsInCart'] = count($list);
					}
				}
			}
		}
	}
	

	public static function getPriceList()
	{
		$products = Product::model()->findAll('1');
		$data = array();
		$item = array();
		foreach($products as $product){
			$item['id'] = $product->id;
			$item['name'] = $product->name;
			$item['code'] = $product->code;
			$item['photo'] = unserialize($product->photo);
			$item['description'] = $product->description;
			$item['color'] = unserialize($product->color);
			$item['size'] = unserialize($product->size);
			$data[]= $item;
		}
		return $data;
	}
	
	public static function getDelivery()
	{
		$delivery = Delivery::model()->findAll('1');
		return $delivery;
	}	

	public static function getPayment()
	{
		$payment = Payment::model()->findAll('1');
		return $payment;
	}	
	
	public function getStoreCart(){
		$fullCart = array();
		foreach($this->storeCart as $product){
			$dbProduct = Product::model()->findByPk($product['id']);
			if ($dbProduct){
				$product['name'] = $dbProduct->name;
				$product['code'] = $dbProduct->code;
				$product['photo'] = unserialize($dbProduct->photo);
				$product['color'] = unserialize($dbProduct->color);
				$product['size'] = unserialize($dbProduct->size);
				$fullCart[] = $product;	
			}
		}
		return $fullCart;	
	}
	
	public function getCustomer(){
		$customer = array();
		$customer['email'] = '';
		
		if (!Yii::app()->user->isGuest){
			$user_id = Yii::app()->user->id;
			$user = User::model()->findByPk($user_id);
		
			$customer['email'] = $user->email;
			$dbCustomer = Customer::model()->findByAttributes(array(
					'email'=>$user->email
			));
		}elseif(isset(Yii::app()->session['storeEmail'])){
			$dbCustomer = Customer::model()->findByAttributes(array(
				'email'=>Yii::app()->session['storeEmail']
			));
		}
		
		if(isset($dbCustomer) && ($dbCustomer)) {
			foreach($dbCustomer as $key=>$attr)
				$customer[$key] = $attr;
		}else{			
			$customer['first_name'] = '';
			$customer['last_name'] = '';
			$customer['target_first_name'] = '';
			$customer['target_last_name'] = '';
			$customer['address'] = '';
			$customer['city'] = '';
			$customer['zip'] = '';
			$customer['phone'] = '';
			$customer['country'] = '';
		}
		
		return $customer;
	}
	
	public function addToCart($newProduct){
		$success = false;
		if(isset($newProduct['id']) && isset($newProduct['quantity']) && isset($newProduct['selectedColor']) && !empty($newProduct['selectedSize'])){
			$added = false;
			$size = count($this->storeCart);
			for ($i = 0; $i < $size; $i++) {
				if( ($newProduct['id'] == $this->storeCart[$i]['id'])
					&& ($newProduct['selectedColor'] == $this->storeCart[$i]['selectedColor'])
					&& ($newProduct['selectedSize'] == $this->storeCart[$i]['selectedSize'])
					&& ($added == false)
				){
					$this->storeCart[$i]['quantity'] += $newProduct['quantity'];
					$added = true;
					break;
				}
			}
			if(!$added){
				$prodArray['id'] = $newProduct['id'];
				$prodArray['quantity'] = $newProduct['quantity'];
				$prodArray['selectedColor'] = $newProduct['selectedColor'];
				$prodArray['selectedSize'] = $newProduct['selectedSize'];
				$this->storeCart[] = $prodArray;
			}
			Yii::app()->session['storeCart'] = $this->storeCart;
			if(isset(Yii::app()->session['itemsInCart']))
				Yii::app()->session['itemsInCart'] = Yii::app()->session['itemsInCart'] + 1;
			else
				Yii::app()->session['itemsInCart'] = 1;
			
			if(isset(Yii::app()->session['storeEmail'])){
				$newCustomer = new stdClass;
				$newCustomer->email = Yii::app()->session['storeEmail'];
				$dbCustomer = Customer::model()->findByAttributes(array(
					'email'=>Yii::app()->session['storeEmail']
				));
				if($dbCustomer){
					$order = StoreOrder::model()->findByAttributes(array(
							'id_customer'=>$dbCustomer->id,
							'status'=>0
						));
					if($order){
						$list = OrderList::model()->findAllByAttributes(array(
							'id_order'=>$order->id
						));
						if($list){
							$added = false;
							foreach($list as $item){
								if( ($newProduct['id'] == $item->id_product)
									&& ($newProduct['selectedColor'] == $item->color)
									&& ($newProduct['selectedSize']['value'] == $item->size_name)
									&& ($added == false)
								){
									$addQuantity = OrderList::model()->findByPK($item->id);
									$addQuantity->quantity += $newProduct['quantity'];
									$addQuantity->save();
									$added = true;
									break;
								}
							}
						}
						if(!$added || !$list){
							$addProduct = new OrderList;
							$addProduct->id_order = $order->id;
							$addProduct->id_product = $newProduct['id'];
							$addProduct->quantity = $newProduct['quantity'];
							$addProduct->color = $newProduct['selectedColor'];
							$addProduct->size_name = $newProduct['selectedColor']['value'];
							$addProduct->price = $newProduct['selectedColor']['price'];
							$addProduct->save();
						}
					}else{
						$this->saveCustomer($newCustomer);
					}
				}else{
					$this->saveCustomer($newCustomer);
				}
			}
			$success = true;
		}
		return $success;
	}
	
	public function deleteFromCart($deleted){
		$success = false;
		
		if(!empty($deleted['id']) && !empty($deleted['selectedColor']) && !empty($deleted['selectedSize'])){
			$newCart = array();
			foreach($this->storeCart as $product) {
				if( !(($deleted['id'] == $product['id'])
					&& ($deleted['selectedColor'] == $product['selectedColor'])
					&& ($deleted['selectedSize']['value'] == $product['selectedSize']['value']))
				){
					$newCart[] = $product;
				}
			}
			$this->storeCart = $newCart;
			Yii::app()->session['storeCart'] = $newCart;
			Yii::app()->session['itemsInCart'] = Yii::app()->session['itemsInCart'] - 1;
			
			if(isset(Yii::app()->session['storeEmail'])){
				$dbCustomer = Customer::model()->findByAttributes(array(
						'email'=>Yii::app()->session['storeEmail']
					));
				if($dbCustomer){
					$order = StoreOrder::model()->findByAttributes(array(
							'id_customer'=>$dbCustomer->id,
							'status'=>0							
					));
					if($order){
						$list = OrderList::model()->findByAttributes(array(
							'id_order'=>$order->id,
							'id_product'=>$deleted['id'],
							'color'=>$deleted['selectedColor'],
							'size_name'=>$deleted['selectedSize']['value']
						));
						if($list)
							$list->delete();
					}
				}
			}
			
			$success = true;
		}
		return $success;
	}
	
	public function saveCustomer($newCustomer){
		$success = false;
		if(isset(Yii::app()->session['storeEmail'])){
			$customer = Customer::model()->findByAttributes(array(
				'email'=>Yii::app()->session['storeEmail']
			));
		}else{
			$customer = Customer::model()->findByAttributes(array(
				'email'=>$newCustomer['email']
			));
		}
		
		if(!isset($customer) || !$customer)
			$customer = new Customer;
		else{
			$order = StoreOrder::model()->findByAttributes(array(
				'id_customer'=>$customer->id,
				'status'=>0
			));
		}
		
		if(!empty($newCustomer['first_name']))
			$customer->first_name = $newCustomer['first_name'];
		if(!empty($newCustomer['last_name']))
			$customer->last_name = $newCustomer['last_name'];
		if(!empty($newCustomer['email']))
			$customer->email = $newCustomer['email'];
		if(!empty($newCustomer['target_first_name']))
			$customer->target_first_name = $newCustomer['target_first_name'];
		if(!empty($newCustomer['target_last_name']))
			$customer->target_last_name = $newCustomer['target_last_name'];
		if(!empty($newCustomer['address']))
			$customer->address = $newCustomer['address'];
		if(!empty($newCustomer['city']))
			$customer->city = $newCustomer['city'];
		if(!empty($newCustomer['zip']))
			$customer->zip = $newCustomer['zip'];
		if(!empty($newCustomer['phone']))
			$customer->phone = $newCustomer['phone'];
		if(!empty($newCustomer['country']))
			$customer->country = $newCustomer['country'];
		$customer->save();
		
		if(!isset($order) || !$order){
			$order = new StoreOrder;
			$order->id_customer = $customer->id;
			$order->status = 0;
			$order->save();
		}else{
			$list = OrderList::model()->findByAttributes(array(
					'id_order'=>$order->id
				));
		}
		
		if(!isset($list) || !$list){		
			foreach($this->storeCart as $product){
				$list = new OrderList;
				$list->id_order = $order->id;
				$list->id_product = $product['id'];
				$list->quantity = $product['quantity'];
				$list->color = $product['selectedColor'];
				$list->size_name = $product['selectedSize']['value'];
				$list->price = $product['selectedSize']['price'];
				$list->save();
			}
		}
		Yii::app()->session['storeEmail'] = $customer->email;
		$success = true;
		
		return $success;
	}	

}