<?php

class Cart extends CFormModel
{

    protected $storeCart = array();

    public function __construct()
    {
        if (isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0) && (!isset(Yii::app()->session['isLoggedIn'])) && (!Yii::app()->user->isGuest))
        {
            //Пользователь залогинился, корзина была заполнена до логина - сохранение нового заказа в базу
            $this->storeCart = Yii::app()->session['storeCart'];
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            if ($user)
            {
                Yii::app()->session['storeEmail'] = $user->email;
                Yii::app()->session['isLoggedIn'] = true;
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => $user->email
                ));
                
                if (!$dbCustomer)
                {
                    $dbCustomer = new Customer;
                    $dbCustomer->email = $user->email;
                    $dbCustomer->save();
                }
                
                $order = StoreOrder::model()->findByAttributes(array(
                    'id_customer' => $dbCustomer->id,
                    'status' => 0
                ));
                
                if(!$order)
                {
                    $order = new StoreOrder;
                    $order->id_customer = $dbCustomer->id;
                    $order->status = 0;
                    $order->save();
                }
                
                OrderList::model()->deleteAll('id_order = :id_order', array(':id_order' => $order->id));
        
                foreach ($this->storeCart as $product)
                {
                    $addProduct = new OrderList;
                    $addProduct->id_order = $order->id;
                    $addProduct->id_product = $product['id'];
                    $addProduct->quantity = $product['quantity'];
                    if (!empty($product['selectedColor']))
                        $addProduct->color = $product['selectedColor'];
                    if (!empty($product['selectedSurface']))
                        $addProduct->surface = $product['selectedSurface'];
                    $addProduct->size_name = $product['selectedSize']['value'];
                    $addProduct->price = $product['selectedSize']['price'];
                    $addProduct->save();
                }
            }
        }
        elseif ((!isset(Yii::app()->session['itemsInCart']) || (Yii::app()->session['itemsInCart'] == 0)) && (!isset(Yii::app()->session['isLoggedIn'])) && (!Yii::app()->user->isGuest))
        {
            //Пользователь залогинился, корзина была пуста до логина - восстановление корзины из базы

            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            if ($user)
                Yii::app()->session['storeEmail'] = $user->email;

            Yii::app()->session['isLoggedIn'] = true;
            $dbCustomer = Customer::model()->findByAttributes(array(
                'email' => $user->email
            ));
        
            if ($dbCustomer)
            {
                $cartList = $this->getCartList($dbCustomer->id);
                Yii::app()->session['storeCart'] = $cartList;
                Yii::app()->session['itemsInCart'] = $this->getListQuantity($cartList);
            }
        }
        elseif (isset(Yii::app()->session['storeCart']))
        {
            $this->storeCart = Yii::app()->session['storeCart'];
        }
    }

    public function getCartList($idCustomer)
    {
        $cartList = array();
        $order = StoreOrder::model()->findByAttributes(array(
            'id_customer' => $idCustomer,
            'status' => 0
        ));
        if ($order)
        {
            $list = OrderList::model()->findAllByAttributes(array(
                'id_order' => $order->id
            ));
            if ($list)
            {
                foreach ($list as $item)
                {
                    $product = array();
                    $selectedSize = array();
                    $product['id'] = $item->id_product;
                    $product['quantity'] = $item->quantity;
                    $product['selectedColor'] = $item->color;
                    $product['selectedSurface'] = $item->surface;
                    $selectedSize['value'] = $item->size_name;
                    $selectedSize['price'] = $item->price;
                    $product['selectedSize'] = $selectedSize;
                    $cartList[] = $product;
                }
            }
        }
        return $cartList;
    }
    
    public function getListQuantity($cartList)
    {
        $itemsInCart = 0;
        
        if(is_array($cartList) && count($cartList))
        {
            foreach($cartList as $item)
                $itemsInCart += $item['quantity'];
        }
        
        return $itemsInCart;
    }

    public function getPriceList()
    {
        $result = Yii::app()->cache->get('products');
            if (!$result)
            {

                $products = Product::model()->findAll('1');
                $data = array();
                $item = array();

                foreach ($products as $product)
                {
                    $item['id'] = $product->id;
                    $item['name'] = $product->name;
                    $item['code'] = $product->code;
                    $item['photo'] = $product->photo;
                    $item['description'] = $product->description;
                    $item['color'] = $product->color;
                    $item['surface'] = $product->surface;
                    $item['size'] = $product->size;

                    $data[] = $item;
                }
                $result = $data;
                Yii::app()->cache->set('products', $result, 120);
            }
        return $result;
    }

    public static function getDelivery()
    {
        $result = Yii::app()->cache->get('delivery');
        if (!$result)
        {
            $result = false;
            $delivery = Delivery::model()->findAll();

            if ($delivery) 
            {
                $result = array();
                foreach ($delivery as $row) {
                    $result[$row->id]['id'] = $row->id;
                    $result[$row->id]['name'] = $row->name;
                    $result[$row->id]['period'] = $row->period;
                    $result[$row->id]['price'] = $row->price;
                } 
            }

            Yii::app()->cache->set('delivery', $result, 120);
        }
        return $result;
    }

    public static function getPayment()
    {
        $result = Yii::app()->cache->get('payment');
        if (!$result)
        {
            $result = false;
            $payment = Payment::model()->findAll();

            if ($payment) 
            {
               $result = array();
                foreach ($payment as $row) {
                    $result[$row->id]['id'] = $row->id;
                    $result[$row->id]['name'] = $row->name;
                    $result[$row->id]['caption'] = $row->caption;
                } 
            }
            Yii::app()->cache->set('payment', $result, 120);
        }
        return $result;
    }

    public function getStoreCart()
    {
        $fullCart = array();
        foreach ($this->storeCart as $product)
        {
            $dbProduct = Product::model()->findByPk($product['id']);
            if ($dbProduct)
            {
                $product['name'] = $dbProduct->name;
                $product['code'] = $dbProduct->code;
                $product['photo'] = $dbProduct->photo;
                $product['color'] = $dbProduct->color;
                $product['surface'] = $dbProduct->surface;
                $product['size'] = $dbProduct->size;
                $fullCart[] = $product;
            }
        }
        return $fullCart;
    }

    public function getDiscount()
    {
        $discount = array();
        $discount['promoCode'] = '';
        $discount['value'] = 0;

        return $discount;
    }
    
    public function getCustomer()
    {
        $customer = array();
        $customer['email'] = '';

        if(isset(Yii::app()->session['storeCustomer']))
        {
            $customer = Yii::app()->session['storeCustomer'];
        }
        else
        {
            if (!Yii::app()->user->isGuest)
            {
                $user_id = Yii::app()->user->id;
                $user = User::model()->findByPk($user_id);

                $customer['email'] = $user->email;
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => $user->email
                ));
            }
            elseif (isset(Yii::app()->session['storeEmail']))
            {
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => Yii::app()->session['storeEmail']
                ));
            }

            if (isset($dbCustomer) && ($dbCustomer))
            {
                foreach ($dbCustomer as $key => $attr)
                    $customer[$key] = $attr;
            }
            else
            {
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
        }
        
        return $customer;
    }

    public function addToCart($newProduct)
    {
        $error = 'error';
        $newProduct['quantity'] = (int) $newProduct['quantity'];
        $valError = $this->validateProduct($newProduct);

        if ($valError == 'no')
        {
            $added = false;
            $size = count($this->storeCart);
            for ($i = 0; $i < $size; $i++)
            {
                if ($this->equalProduct($newProduct, $this->storeCart[$i]) && !$added)
                {
                    $this->storeCart[$i]['quantity'] += $newProduct['quantity'];
                    $added = true;
                    break;
                }
            }
            if (!$added)
            {
                $prodArray['id'] = $newProduct['id'];
                $prodArray['quantity'] = $newProduct['quantity'];
                if (!empty($newProduct['selectedColor']))
                    $prodArray['selectedColor'] = $newProduct['selectedColor'];
                if (!empty($newProduct['selectedSurface']))
                    $prodArray['selectedSurface'] = $newProduct['selectedSurface'];
                $prodArray['selectedSize'] = $newProduct['selectedSize'];
                $this->storeCart[] = $prodArray;
            }
            Yii::app()->session['storeCart'] = $this->storeCart;
            if (isset(Yii::app()->session['itemsInCart']))
                Yii::app()->session['itemsInCart'] += $newProduct['quantity'];
            else
                Yii::app()->session['itemsInCart'] = $newProduct['quantity'];

            if (isset(Yii::app()->session['storeEmail']))
            {
                $newCustomer = array();
                $newCustomer['email'] = Yii::app()->session['storeEmail'];
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => Yii::app()->session['storeEmail']
                ));
                if ($dbCustomer)
                {
                    $order = StoreOrder::model()->findByAttributes(array(
                        'id_customer' => $dbCustomer->id,
                        'status' => 0
                    ));
                    if ($order)
                    {
                        $list = OrderList::model()->findAllByAttributes(array(
                            'id_order' => $order->id
                        ));
                        if ($list)
                        {
                            $added = false;
                            foreach ($list as $item)
                            {
                                if ($this->equalProduct($newProduct, $item) && ($added == false))
                                {
                                    $addQuantity = OrderList::model()->findByPK($item->id);
                                    $addQuantity->quantity += $newProduct['quantity'];
                                    $addQuantity->save();
                                    $added = true;
                                    break;
                                }
                            }
                        }
                        if (!$added || !$list)
                        {
                            $addProduct = new OrderList;
                            $addProduct->id_order = $order->id;
                            $addProduct->id_product = $newProduct['id'];
                            $addProduct->quantity = $newProduct['quantity'];
                            if (!empty($newProduct['selectedColor']))
                                $addProduct->color = $newProduct['selectedColor'];
                            if (!empty($newProduct['selectedSurface']))
                                $addProduct->surface = $newProduct['selectedSurface'];
                            $addProduct->size_name = $newProduct['selectedSize']['value'];
                            $addProduct->price = $newProduct['selectedSize']['price'];
                            $addProduct->save();
                        }
                    }else
                    {
                        $this->saveCustomer($newCustomer);
                    }
                }
                else
                {
                    $this->saveCustomer($newCustomer);
                }
            }
            $error = 'no';
        }
        else
            $error = $valError;
        return $error;
    }

    public function equalProduct($product, $etalon)
    {
        $answer = false;
        if (!is_array($etalon) && isset($etalon->id_order) && isset($etalon->id_product))
        {
            //etalone from order_list
            if (
                    ( isset($product['id']) && ($product['id'] == $etalon->id_product)) && ( (empty($product['selectedColor']) && $etalon->color == null) ||
                    (!empty($product['selectedColor']) && !empty($etalon->color) && ($product['selectedColor'] == $etalon->color))) && ( ($product['selectedSize']['value'] == $etalon->size_name) && ($product['selectedSize']['price'] == $etalon->price)) && ( (empty($product['selectedSurface']) && ($etalon->surface == null)) ||
                    (!empty($product['selectedSurface']) && !empty($etalon->surface) && ($product['selectedSurface'] == $etalon->surface)))
            )
            {
                $answer = true;
            }
        }
        else
        {
            //etalone from session
            if (
                    ( isset($product['id']) && isset($etalon['id']) && ($product['id'] == $etalon['id'])) && ( (empty($product['selectedColor']) && empty($etalon['selectedColor'])) ||
                    (!empty($product['selectedColor']) && !empty($etalon['selectedColor']) && ($product['selectedColor'] == $etalon['selectedColor']))) && ($product['selectedSize'] == $etalon['selectedSize']) && ( (empty($product['selectedSurface']) && empty($etalon['selectedSurface'])) ||
                    (!empty($product['selectedSurface']) && !empty($etalon['selectedSurface']) && ($product['selectedSurface'] == $etalon['selectedSurface'])))
            )
            {
                $answer = true;
            }
        }
        return $answer;
    }

    public function validateProduct($newProduct)
    {
        $error = 'error';
        if (isset($newProduct['id']) && isset($newProduct['quantity']))
        {
            if (is_int($newProduct['quantity']) && ($newProduct['quantity'] > 0))
            {
                $etalone = Product::model()->findByPK($newProduct['id']);
                if ($etalone)
                {
                    $etalone->color = $etalone->color;
                    $etalone->size = $etalone->size;
                    $etalone->surface = $etalone->surface;
                    if ((!is_array($etalone->color)) || in_array($newProduct['selectedColor'], $etalone->color))
                    {
                        $correctSize = false;
                        foreach ($etalone->size as $size)
                        {
                            if (($size['value'] == $newProduct['selectedSize']['value']) && ($size['price'] == $newProduct['selectedSize']['price']))
                                $correctSize = true;
                        }
                        if ($correctSize)
                        {
                            $error = 'no';
                        }
                        else
                            Yii::t('store', 'Incorrect size');
                    }
                    else
                        $error = Yii::t('store', 'Incorrect color');
                }
                else
                    $error = Yii::t('store', 'Product not found!');
            }
            else
                $error = Yii::t('store', 'Incorrect quantity!');
        }
        else
            $error = Yii::t('store', 'Пожалуйста, заполните все обязательные поля!');

        return $error;
    }

    public function deleteFromCart($deleted)
    {
        $success = false;

        if (!empty($deleted['id']) && !empty($deleted['selectedSize']))
        {
            $newCart = array();
            foreach ($this->storeCart as $product)
            {
                if (!$this->equalProduct($deleted, $product))
                {
                    $newCart[] = $product;
                }
            }
            $this->storeCart = $newCart;
            Yii::app()->session['storeCart'] = $newCart;
            Yii::app()->session['itemsInCart'] = Yii::app()->session['itemsInCart'] - $deleted['quantity'];

            if (isset(Yii::app()->session['storeEmail']))
            {
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => Yii::app()->session['storeEmail']
                ));
                if ($dbCustomer)
                {
                    $order = StoreOrder::model()->findByAttributes(array(
                        'id_customer' => $dbCustomer->id,
                        'status' => 0
                    ));
                    if (empty($deleted['selectedColor']))
                        $deleted['selectedColor'] = null;
                    if (empty($deleted['selectedSurface']))
                        $deleted['selectedSurface'] = null;
                    if ($order)
                    {
                        $list = OrderList::model()->findByAttributes(array(
                            'id_order' => $order->id,
                            'id_product' => $deleted['id'],
                            'color' => $deleted['selectedColor'],
                            'surface' => $deleted['selectedSurface'],
                            'size_name' => $deleted['selectedSize']['value']
                        ));
                        if ($list)
                            $list->delete();
                    }
                }
            }

            $success = true;
        }
        return $success;
    }

    public function confirmPromo($userCode)
    {
        $discount = array();
        $discount['error'] = Yii::t('store', 'Введен неверный код!');
        $discount['promoCode'] = $userCode;
    
        $promoCode = PromoCode::model()->findByAttributes(array(
            'code' => $userCode
        ));
        
        if ($promoCode)
        {
            if ($promoCode->expires < Time())
                $discount['error'] = Yii::t('store', 'Код устарел!');
            elseif (!$promoCode->is_multifold && $promoCode->used)
            {
                $discount['error'] = Yii::t('store', 'Код уже был использован!');
            }
            else
            {
                $discount['products'] = $promoCode->products;
                $discount['error'] = 'no';
            }
        }
    
        return $discount;
    }

    public function saveCustomer($newCustomer)
    {
        $error = Yii::t('store', 'Пожалуйста, заполните все обязательные поля!');
        if (isset(Yii::app()->session['storeEmail']))
        {
            $customer = Customer::model()->findByAttributes(array(
                'email' => Yii::app()->session['storeEmail']
            ));
        }
        else
        {
            $customer = Customer::model()->findByAttributes(array(
                'email' => $newCustomer['email']
            ));
        }

        if (!isset($customer) || !$customer)
            $customer = new Customer;
        else
        {
            $order = StoreOrder::model()->findByAttributes(array(
                'id_customer' => $customer->id,
                'status' => 0
            ));
        }

        if (!empty($newCustomer['first_name']))
            $customer->first_name = $newCustomer['first_name'];
        if (!empty($newCustomer['last_name']))
            $customer->last_name = $newCustomer['last_name'];
        if (!Yii::app()->user->isGuest)
        {
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            if ($user)
                $customer->email = $user->email;
            elseif (!empty($newCustomer['email']))
                $customer->email = $newCustomer['email'];
        }elseif (!empty($newCustomer['email']))
            $customer->email = $newCustomer['email'];
        if (!empty($newCustomer['target_first_name']))
            $customer->target_first_name = $newCustomer['target_first_name'];
        if (!empty($newCustomer['target_last_name']))
            $customer->target_last_name = $newCustomer['target_last_name'];
        if (!empty($newCustomer['address']))
            $customer->address = $newCustomer['address'];
        if (!empty($newCustomer['city']))
            $customer->city = $newCustomer['city'];
        if (!empty($newCustomer['zip']))
            $customer->zip = $newCustomer['zip'];
        if (!empty($newCustomer['phone']))
            $customer->phone = $newCustomer['phone'];
        if (!empty($newCustomer['country']))
            $customer->country = $newCustomer['country'];

        if ($customer->validate())
        {
            $customer->save();

            if (!isset($order) || !$order)
            {
                $order = new StoreOrder;
                $order->id_customer = $customer->id;
                $order->status = 0;
                $order->save();
            }
            else
            {
                $list = OrderList::model()->findByAttributes(array(
                    'id_order' => $order->id
                ));
            }

            if (!isset($list) || !$list)
            {
                foreach ($this->storeCart as $product)
                {
                    $list = new OrderList;
                    $list->id_order = $order->id;
                    $list->id_product = $product['id'];
                    $list->quantity = $product['quantity'];
                    if (isset($product['selectedColor']))
                        $list->color = $product['selectedColor'];
                    if (isset($product['selectedSurface']))
                        $list->surface = $product['selectedSurface'];
                    $list->size_name = $product['selectedSize']['value'];
                    $list->price = $product['selectedSize']['price'];
                    $list->save();
                }
            }
            Yii::app()->session['storeEmail'] = $customer->email;
            $error = 'no';
        } else
        {
            $modelErrors = $this->getErrors();
            $error = '';
            foreach ($modelErrors as $mError)
            {
                $error .= $mError . ' /n';
            }
        }
        return $error;
    }

    public function validateCustomer($newCustomer)
    {
        $error = Yii::t('store', 'Пожалуйста, заполните все обязательные поля!');
        Yii::app()->session['storeCustomer'] = $newCustomer;
        
        if (!Yii::app()->user->isGuest)
        {
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            if ($user)
                $newCustomer['email'] = $user->email;
        }
        
        if (!empty($newCustomer['email']))
        {
            Yii::app()->session['storeEmail'] = $newCustomer['email'];
            $customer = Customer::model()->findByAttributes(array(
                'email' => $newCustomer['email']
            ));
        }
        
        if (!isset($customer) || !$customer)
        {
            $customer = new Customer;
            if (!empty($newCustomer['email']))
                $customer->email = $newCustomer['email'];
        }
        
        if (!empty($newCustomer['first_name']))
            $customer->first_name = $newCustomer['first_name'];
        if (!empty($newCustomer['last_name']))
            $customer->last_name = $newCustomer['last_name'];
        
        if (!empty($newCustomer['target_first_name']))
            $customer->target_first_name = $newCustomer['target_first_name'];
        if (!empty($newCustomer['target_last_name']))
            $customer->target_last_name = $newCustomer['target_last_name'];
        if (!empty($newCustomer['address']))
            $customer->address = $newCustomer['address'];
        if (!empty($newCustomer['city']))
            $customer->city = $newCustomer['city'];
        if (!empty($newCustomer['zip']))
            $customer->zip = $newCustomer['zip'];
        if (!empty($newCustomer['phone']))
            $customer->phone = $newCustomer['phone'];
        if (!empty($newCustomer['country']))
            $customer->country = $newCustomer['country'];

        if ($customer->validate())
        {
            $error = 'no';
        } 
        else
        {
            $modelErrors = $customer->getErrors();
            $error = '';
            foreach ($modelErrors as $mError)
            {
                if (is_array($mError))
                {
                    foreach ($mError as $subError)
                    {
                        if (is_array($subError))
                            $error .= print_r($subError, true) . ' ';
                        else
                            $error .= $subError . ' ';
                    }
                }
                else
                    $error .= $mError . ' ';
            }
        }
        return $error;
    }
    
    public function buy($newCustomer, $products, $discount, $selectedDelivery, $selectedPayment)
    {
        $mailOrder = array();
        $error = Yii::t('store', 'Пожалуйста, заполните все обязательные поля!');
        Yii::app()->session['storeCustomer'] = $newCustomer;
        if (isset(Yii::app()->session['storeEmail']))
        {
            $customer = Customer::model()->findByAttributes(array(
                'email' => Yii::app()->session['storeEmail']
            ));
        }
        else
        {
            $customer = Customer::model()->findByAttributes(array(
                'email' => $newCustomer['email']
            ));
        }
        
        if (!isset($customer) || !$customer)
            $customer = new Customer;
        
        if (!empty($newCustomer['first_name']))
            $customer->first_name = $newCustomer['first_name'];
        if (!empty($newCustomer['last_name']))
            $customer->last_name = $newCustomer['last_name'];
        if (!Yii::app()->user->isGuest)
        {
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            if ($user)
                $customer->email = $user->email;
        }elseif (!empty($newCustomer['email']))
            $customer->email = $newCustomer['email'];
        if (!empty($newCustomer['target_first_name']))
            $customer->target_first_name = $newCustomer['target_first_name'];
        if (!empty($newCustomer['target_last_name']))
            $customer->target_last_name = $newCustomer['target_last_name'];
        if (!empty($newCustomer['address']))
            $customer->address = $newCustomer['address'];
        if (!empty($newCustomer['city']))
            $customer->city = $newCustomer['city'];
        if (!empty($newCustomer['zip']))
            $customer->zip = $newCustomer['zip'];
        if (!empty($newCustomer['phone']))
            $customer->phone = $newCustomer['phone'];
        if (!empty($newCustomer['country']))
            $customer->country = $newCustomer['country'];

        if ($customer->validate())
        {

            $customer->save();

            $order = StoreOrder::model()->findByAttributes(array(
                'id_customer' => $customer->id,
                'status' => 0
            ));

            if (!isset($order) || !$order)
            {
                $order = new StoreOrder;
                $order->id_customer = $customer->id;
                $order->status = 0;
                $order->save();
            }

            $model = OrderList::model();
            $transaction = $model->dbConnection->beginTransaction();
            try
            {
                OrderList::model()->deleteAll('id_order = :id_order', array(':id_order' => $order->id));
                $items = array();

                $subtotal = 0;

                foreach ($products as $product)
                {
                    $list = new OrderList;
                    $item = array();
                    $list->id_order = $order->id;
                    $list->id_product = $product['id'];
                    $item['id_product'] = $product['id'];
                    $list->quantity = $product['quantity'];
                    $item['quantity'] = $product['quantity'];
                    if (isset($product['selectedColor']))
                    {
                        $list->color = $product['selectedColor'];
                        $item['color'] = $product['selectedColor'];
                    }
                    else
                        $item['color'] = '';
                    if (isset($product['selectedSurface']))
                    {
                        $list->surface = $product['selectedSurface'];
                        $item['surface'] = $product['selectedSurface'];
                    }
                    else
                        $item['surface'] = '';
                    $list->size_name = $product['selectedSize']['value'];
                    $item['size_name'] = str_replace('single', '-', $product['selectedSize']['value']);
                    $dbProduct = Product::model()->findByPk($product['id']);
                    $item['name'] = $dbProduct->name;
                    $items['code'] = $dbProduct->code;
                    $dbSizes = $dbProduct->size;
                    foreach ($dbSizes as $dbSize)
                    {
                        if ($dbSize['value'] == $product['selectedSize']['value'])
                        {
                            $list->price = $dbSize['price'];
                            $item['price'] = $dbSize['price'];
                        }
                    }
                    
                    $list->save();
                    $items[] = $item;
                    $subtotal += $list->price * $list->quantity;
                }

                $tax = 0;
                $discountSumm = 0;

                if (!empty($discount['promoCode']) && !empty($discount['summ']))
                {
                    $promoCode = PromoCode::model()->findByAttributes(array(
                        'code' => $discount['promoCode']
                    ));
        
                    if ($promoCode)
                    {
                        if ($promoCode->expires > Time() && !(!$promoCode->is_multifold && $promoCode->used))
                        {
                            $promoProducts = $promoCode->products;
                            foreach ($products as $product)
                            {
                                foreach ($promoProducts as $promoId)
                                {
                                    if (($promoId['id_product'] == $product['id']) && ($product['selectedSize']['price'] >= $promoId['discount']))
                                    {
                                        $discountSumm += $promoId['discount']*$product['quantity'];
                                        break;
                                    }
                                }
                            }
                            
                            if ($discountSumm > 0)
                            {
                                $order->promo_id = $promoCode->id;
                                if (!$promoCode->used)
                                {
                                    $promoCode->used = true;
                                    $promoCode->save();
                                }
                            }
                        }
                    }
                }
                
                $mailOrder['id'] = $order->id;
                $mailOrder['email'] = $customer->email;
                $mailOrder['target_first_name'] = $customer->target_first_name;
                $mailOrder['target_last_name'] = $customer->target_last_name;
                $mailOrder['address'] = $customer->address;
                $mailOrder['city'] = $customer->city;
                $mailOrder['zip'] = $customer->zip;
                $mailOrder['customer_id'] = $order->id_customer;

                $mailOrder['delivery_id'] = $order->delivery;
                $deliv = Delivery::model()->findByAttributes(array(
                    'name' => $selectedDelivery['name']
                ));
                $mailOrder['subtotal'] = $subtotal;
                if ($discountSumm > 0)
                    $mailOrder['discount'] = $discountSumm;
                $mailOrder['tax'] = $tax;
                $mailOrder['items'] = $items;

                if ($deliv)
                {
                    $mailOrder['delivery'] = $deliv->name;
                    $mailOrder['shipping'] = $deliv->price;
                    $mailOrder['total'] = $subtotal + $deliv->price - $discountSumm;
                    $order->delivery = $deliv->id;

                    $error = 'no';
                }
                else
                    $error = Yii::t('store', 'Incorrect delivery!');

                $pay = Payment::model()->findByAttributes(array(
                    'name' => $selectedPayment['name']
                ));
                
                if ($pay)
                {
                    $mailOrder['payment'] = $pay->name;
                    $order->payment = $pay->id;
                } 
                else
                    $error = Yii::t('store', 'Incorrect payment!');
                
                $order->status = 1;
                $order->save();
                
                $transaction->commit();
                $this->storeCart = array();
                unset(Yii::app()->session['storeCart']);
                Yii::app()->session['itemsInCart'] = 0;
            } catch (Exception $e)
            {
                $transaction->rollback();
                $error = $e;
            }
        }
        else
        {
            $modelErrors = $customer->getErrors();
            $error = '';
            foreach ($modelErrors as $mError)
            {
                if (is_array($mError))
                {
                    foreach ($mError as $subError)
                    {
                        if (is_array($subError))
                            $error .= print_r($subError, true) . ' ';
                        else
                            $error .= $subError . ' ';
                    }
                }
                else
                    $error .= $mError . ' ';
            }
        }

        $mailOrder['error'] = $error;
        return $mailOrder;
    }

    public static function getMessageByOrder($orderId)
    {
        $mailOrder = array();
        
        $order = StoreOrder::model()->findByPk($orderId);
        if ($order)
        {
            $customer = Customer::model()->findByPk($order->id_customer);
            
            $mailOrder['id'] = $order->id;
            $mailOrder['email'] = $customer->email;
            $mailOrder['phone'] = $customer->phone;
            $mailOrder['target_first_name'] = $customer->target_first_name;
            $mailOrder['target_last_name'] = $customer->target_last_name;
            $mailOrder['address'] = $customer->address;
            $mailOrder['city'] = $customer->city;
            $mailOrder['zip'] = $customer->zip;
            $mailOrder['customer_id'] = $order->id_customer;
            $mailOrder['delivery_id'] = $order->delivery;
            $deliv = Delivery::model()->findByPk($order->delivery);
            $mailOrder['delivery'] = $deliv->name;
            $mailOrder['shipping'] = $deliv->price;
            $pay = Payment::model()->findByPk($order->payment);
            $mailOrder['payment'] = $pay->name;
            
            $list = OrderList::model()->findAllByAttributes(array(
                'id_order' => $order->id
            ));
            
            $items = array();
            $subtotal = 0;
            $tax = 0;
            $discountSumm = 0;
            
            foreach ($list as $product)
            {
                $item = array();
                $selectedSize = array();
                $item['id_product'] = $product->id_product;
                $dbProduct = Product::model()->findByPk($product->id_product);
                $item['name'] = $dbProduct->name;
                $item['code'] = $dbProduct->code;
                $item['quantity'] = $product->quantity;
                $item['color'] = $product->color;
                $item['surface'] = $product->surface;
                $item['size_name'] = str_replace('standart', '-', $product->size_name);
                $item['price'] = $product->price;
                $items[] = $item;
                $subtotal += $item['price'] * $item['quantity'];
            }
            

            $promoCode = PromoCode::Model()->findByPk($order->promo_id);
            if ($promoCode)
            {
                $promoProducts = $promoCode->products;
                foreach ($list as $product)
                {
                    foreach ($promoProducts as $promoId)
                    {
                        if (($promoId['id_product'] == $product->id_product) && ($product->price >= $promoId['discount']))
                        {
                            $discountSumm += $promoId['discount']*$product->quantity;
                            break;
                        }
                    }
                }
            }
            
            $mailOrder['subtotal'] = $subtotal;
            if ($discountSumm > 0)
                $mailOrder['discount'] = $discountSumm;
            $mailOrder['tax'] = $tax;
            $mailOrder['total'] = $subtotal + $deliv->price - $discountSumm;
            $mailOrder['items'] = $items;
        }
            
        return $mailOrder;
    }
}