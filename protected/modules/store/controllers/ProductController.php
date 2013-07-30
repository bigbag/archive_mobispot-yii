<?php

class ProductController extends MController
{

    public $layout = '//layouts/store';
    public $imagePath = '/themes/mobispot/images/product/';

    public function actionIndex()
    {
        $this->render('index', array('imagePath' => $this->imagePath));
    }

    public function actionCart()
    {
        $this->render('cart', array('imagePath' => $this->imagePath));
    }

    public function actionGetPriceList()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                $cart = new Cart;
                $answer['products'] = $cart->getPriceList();
                $settings = array();
                $settings['addToCart'] = Yii::t('store', 'Add to cart');
                $settings['added'] = Yii::t('store', 'Added');
                $answer['settings'] = $settings;
                /*
                  if(isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0))
                  $answer['itemsInCart'] = Yii::app()->session['itemsInCart'];
                  else
                  $answer['itemsInCart'] = 0;
                 */
                header('Content-Type: application/json; charset=UTF-8');
                echo CJSON::encode($answer);
            }
        }
        Yii::app()->end();
    }

    public function actionGetCart()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                $cart = new Cart;
                $data = array();
                $data['products'] = $cart->getStoreCart();
                $data['discount'] = $cart->getDiscount();
                header('Content-Type: application/json; charset=UTF-8');
                echo CJSON::encode($data);
                Yii::app()->end();
            }
        }
    }

    public function actionGetCustomer()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
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

    public function actionAddToCart()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $answer = array();
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                $cart = new Cart;
                $answer['error'] = $cart->addToCart($data);
                //$answer['itemsInCart'] = Yii::app()->session['itemsInCart'];
            }
            header('Content-Type: application/json; charset=UTF-8');
            echo CJSON::encode($answer);
            Yii::app()->end();
        }
    }

    public function actionDeleteFromCart()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $answer = array();
            $answer['error'] = '-1';
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                $cart = new Cart;
                if ($cart->deleteFromCart($data))
                {
                    $answer['error'] = 'no';
                }
            }
            header('Content-Type: application/json; charset=UTF-8');
            echo CJSON::encode($answer);
            Yii::app()->end();
        }
    }

    public function actionConfirmPromo()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $answer = array();
            $answer['error'] = Yii::t('store', 'Please, enter the code!');
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                if(!empty($data['promoCode']))
                {
                    $cart = new Cart;
                    $discount = $cart->confirmPromo($data['promoCode']);
                    $answer['error'] = $discount['error'];
                    $answer['discount'] = $discount;
                }
            }
            header('Content-Type: application/json; charset=UTF-8');
            echo CJSON::encode($answer);
            Yii::app()->end();
        }
    }

    public function actionSaveCustomer()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $answer = array();
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                if (isset($data['customer']))
                {
                    $cart = new Cart;
                    $answer['error'] = $cart->saveCustomer($data['customer']);
                    if ($answer['error'] == 'no')
                    {
                        $answer['message'] = Yii::t('store', 'Saved!');
                    }
                }
                else
                    $answer['error'] = Yii::t('store', 'Please, fill all required fields!');
            }
            header('Content-Type: application/json; charset=UTF-8');
            echo CJSON::encode($answer);
            Yii::app()->end();
        }
    }

    public function actionGetItemsInCart()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken)
            {
                $answer = array();
                $cart = new Cart;
                if (isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0))
                    $answer['itemsInCart'] = Yii::app()->session['itemsInCart'];
                else
                    $answer['itemsInCart'] = 0;
                header('Content-Type: application/json; charset=UTF-8');
                echo CJSON::encode($answer);
            }
        }
        Yii::app()->end();
    }

    public function actionBuy()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $answer = array();
            $data = $this->getJson();
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken && isset($data['customer']) && isset($data['products']) && isset($data['delivery']) && isset($data['payment']) && isset($data['discount']))
            {
                $cart = new Cart;
                $mailOrder = $cart->buy($data['customer'], $data['products'], $data['discount'], $data['delivery'], $data['payment']);
                $answer['error'] = $mailOrder['error'];
                if ($mailOrder['error'] == 'no')
                {
                    if ($mailOrder['payment'] == 'Uniteller')
                    {
                        $answer['payment'] = $mailOrder['payment'];
                        $payment = Yii::app()->ut;
                        $order['shopId'] = $payment->shopId;
                        $order['customerId'] = $mailOrder['customer_id'];
                        $order['orderId'] = $mailOrder['id'];
                        $order['amount'] = $mailOrder['total'];
                        $order['signature'] = $payment->getPaySign($order);
                        $token = sha1(Yii::app()->request->csrfToken);
                        $order['return_ok'] = $this->createAbsoluteUrl('/store/product/PayUniteller') . '?result=success&token=' . $token;
                        $order['return_error'] = $this->createAbsoluteUrl('/store/product/PayUniteller') . '?result=error&token=' . $token;
                        $answer['order'] = $order;
                    }
                }
            }
            echo CJSON::encode($answer);
        }
        Yii::app()->end();
    }
    
    public function actionPayUniteller()
    {
        $token = Yii::app()->request->getParam('token', 0);
        $orderId = Yii::app()->request->getParam('Order_ID', 0);

        if ($token and $token == sha1(Yii::app()->request->csrfToken) and $orderId)
        {
            $order = StoreOrder::model()->findByPk($orderId);
            if ($order && $order->status == 1)
            {
                $payment = Yii::app()->ut;
            
                $sPostFields = "Shop_ID=" . $payment->shopId . "&Login=" . $payment->login . "&Password=" . $payment->pass . "&Format=1&ShopOrderNumber=" . $order->id . "&S_FIELDS=Status;ApprovalCode;BillNumber"; 

                $ch = curl_init(); 
                curl_setopt($ch, CURLOPT_URL, $payment->getResultUrl());
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
   
                $data = array();
                if (!$curl_error) 
                {
                    $arr = explode( ";", $curl_response); 
                    if (count($arr) > 2) 
                    { 
                        $data = array( 
                            "Status" => $arr[0],
                            "ApprovalCode" => $arr[1],
                            "BillNumber"   => $arr[2] 
                        ); 
                        
                        $order->payment_data = $data;

                        if (strtolower($data['Status']) == 'authorized' || strtolower($data['Status']) == 'paid')
                        {
                            $mailOrder = Cart::getMessageByOrder($order->id);
                            $to = array();
                            $to[] = $mailOrder['email'];
                            $to[] = Yii::app()->par->load('generalEmail');//admiin
                            
                            $order->status = 2;
                            MMail::order_track($to, $mailOrder, $this->getLang());
                        }
                        else
                        {
                            $order->status = -1;
                            
                            if (!isset(Yii::app()->session['itemsInCart']) || Yii::app()->session['itemsInCart'] == 0)
                            {
                                //Восстановление заказа в корзину
                                $cartList = array();
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
                                Yii::app()->session['storeCart'] = $cartList;
                                Yii::app()->session['itemsInCart'] = count($cartList);
                                
                                //Восстановление одноразового промо-кода
                                if (!empty($order->promo_id))
                                {
                                    $promoCode = PromoCode::model()->findByPk($order->promo_id);
                                    if ($promoCode && !$promoCode->is_multifold && $promoCode->used)
                                    {
                                        $promoCode->used = false;
                                        $promoCode->save();
                                    }
                                }
                            }
                        }
                        $order->save();
                    }
                }
            }
        }
        $this->redirect('/store');
    }
}
