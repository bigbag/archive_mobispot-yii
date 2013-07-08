<?php

class Cart extends CFormModel
{

    protected $storeCart = array();

    public function __construct()
    {
        if (isset(Yii::app()->session['storeCart']) && (!isset(Yii::app()->session['storeEmail'])) && (!Yii::app()->user->isGuest))
        {
            $this->storeCart = Yii::app()->session['storeCart'];
            $user_id = Yii::app()->user->id;
            $user = User::model()->findByPk($user_id);
            if ($user)
            {
                Yii::app()->session['storeEmail'] = $user->email;
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => $user->email
                ));
                if ($dbCustomer)
                {
                    $dbCartList = $this->getCartList($dbCustomer->id);
                    foreach ($dbCartList as $dbProduct)
                    {
                        $this->storeCart[] = $dbProduct;
                    }
                    Yii::app()->session['storeCart'] = $this->storeCart;
                    Yii::app()->session['itemsInCart'] = count($this->storeCart);
                }
            }
        }
        elseif (isset(Yii::app()->session['storeCart']))
        {
            $this->storeCart = Yii::app()->session['storeCart'];
        }
        else
        {
            if (!Yii::app()->user->isGuest)
            {
                $user_id = Yii::app()->user->id;
                $user = User::model()->findByPk($user_id);
                if ($user)
                    Yii::app()->session['storeEmail'] = $user->email;

                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => $user->email
                ));
            }elseif (isset(Yii::app()->session['storeEmail']))
            {
                $dbCustomer = Customer::model()->findByAttributes(array(
                    'email' => Yii::app()->session['storeEmail']
                ));
            }

            if (isset($dbCustomer) && ($dbCustomer))
            {
                $cartList = $this->getCartList($dbCustomer->id);
                Yii::app()->session['storeCart'] = $cartList;
                Yii::app()->session['itemsInCart'] = count($cartList);
            }
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

    public function getPriceList()
    {
        $products = Product::model()->findAll('1');
        $data = array();
        $item = array();
        $itemsInCart = 0;
        if (isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0))
            $itemsInCart = Yii::app()->session['itemsInCart'];
        foreach ($products as $product)
        {
            $item['id'] = $product->id;
            $item['name'] = $product->name;
            $item['code'] = $product->code;
            $item['photo'] = unserialize($product->photo);
            $item['description'] = $product->description;
            $item['color'] = unserialize($product->color);
            $item['surface'] = unserialize($product->surface);
            $item['size'] = unserialize($product->size);
            $item['totalInCart'] = 0;
            if ($itemsInCart > 0)
            {
                foreach ($this->storeCart as $cartItem)
                {
                    if ($cartItem['id'] == $item['id'])
                    {
                        $item['totalInCart'] = $item['totalInCart'] + $cartItem['quantity'];
                    }
                }
            }
            $data[] = $item;
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
                $product['photo'] = unserialize($dbProduct->photo);
                $product['color'] = unserialize($dbProduct->color);
                $product['surface'] = unserialize($dbProduct->surface);
                $product['size'] = unserialize($dbProduct->size);
                $fullCart[] = $product;
            }
        }
        return $fullCart;
    }

    public function getCustomer()
    {
        $customer = array();
        $customer['email'] = '';

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
            Yii::app()->session['itemsInCart'] = count($this->storeCart);

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
                    $etalone->color = unserialize($etalone->color);
                    $etalone->size = unserialize($etalone->size);
                    $etalone->surface = unserialize($etalone->surface);
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
            $error = Yii::t('store', 'Fill all required fields!');

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
            Yii::app()->session['itemsInCart'] = count($this->storeCart);

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

    public function saveCustomer($newCustomer)
    {
        $error = '';
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
            $modelErrors = getErrors();
            foreach ($modelErrors as $mError)
            {
                $error .= $mError . ' /n';
            }
        }
        return $error;
    }

    public function buy($dcustomer, $products, $selectedDelivery, $selectedPayment)
    {
        $mailOrder = array();
        $error = Yii::t('store', 'Fill all required fields!');
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
                foreach ($this->storeCart as $product)
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
                    $list->price = $product['selectedSize']['price'];
                    $item['price'] = $product['selectedSize']['price'];
                    $list->save();

                    $items[] = $item;
                    $subtotal += $list->price;
                }

                $transaction->commit();

                $iSize = count($items);
                for ($i = 0; $i < $iSize; $i++)
                {
                    $dbProduct = Product::model()->findByPk($items[$i]['id_product']);
                    if ($dbProduct)
                    {
                        $items[$i]['name'] = $dbProduct->name;
                        $items[$i]['code'] = $dbProduct->code;
                    }
                }

                $tax = 0;

                $mailOrder['id'] = $order->id;
                $mailOrder['email'] = $customer->email;
                $mailOrder['target_first_name'] = $customer->target_first_name;
                $mailOrder['target_last_name'] = $customer->target_last_name;
                $mailOrder['address'] = $customer->address;
                $mailOrder['city'] = $customer->city;
                $mailOrder['zip'] = $customer->zip;


                $mailOrder['delivery_id'] = $order->delivery_id;
                $deliv = Delivery::model()->findByAttributes(array(
                    'name' => $selectedDelivery
                ));
                $mailOrder['subtotal'] = $subtotal;
                $mailOrder['tax'] = $tax;
                $mailOrder['items'] = $items;

                if ($deliv)
                {
                    $mailOrder['delivery'] = $deliv->name;
                    $mailOrder['shipping'] = $deliv->price;
                    $mailOrder['total'] = $subtotal + $deliv->price;

                    $error = 'no';
                }
                else
                    $error = Yii::t('store', 'Incorrect delivery!');
            } catch (Exception $e)
            {
                $transaction->rollback();
                $error = $e;
                //$error = print_r($e, true);
            }
        }
        else
        {
            $modelErrors = getErrors();
            foreach ($modelErrors as $mError)
            {
                $error .= $mError . ' /n';
            }
        }
        $mailOrder['error'] = $error;
        return $mailOrder;
    }

}