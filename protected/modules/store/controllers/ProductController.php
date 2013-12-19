<?php

class ProductController extends MController
{

    public $layout = '//layouts/store';
    public $imagePath = '/themes/mobispot/images/product/';

    public function actionIndex()
    {
        $this->render('index', 
            array(
                'imagePath' => $this->imagePath,
                'items_count' => $this->getItemsInCart(),
                )
            );
    }

    public function actionCart()
    {
        $this->render('cart', 
            array(
                'imagePath' => $this->imagePath,
                
                )
            );
    }

    public function actionGetPriceList()
    {
        $data = $this->validateRequest();
        $answer = array();

        $cart = new StoreCart;
        $answer['products'] = $cart->getPriceList();
        $settings = array();
        $settings['addToCart'] = Yii::t('store', 'Add to cart');
        $settings['added'] = Yii::t('store', 'Added');
        $answer['settings'] = $settings;

        echo json_encode($answer);
    }

    
    public function getItemsInCart()
    {
        $count = 0;
        $cart = new StoreCart; //для проверки в конструкторе Cart - если юзер залогинился
        if (isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0))
        {
            $count = Yii::app()->session['itemsInCart'];
        }

        return $count;
    }


    public function actionGetCart()
    {
        $data = $this->validateRequest();
        $answer = array();
        
        $cart = new StoreCart;
        $answer = array();
        $answer['products'] = $cart->getStoreCart();
        $answer['discount'] = $cart->getDiscount();

        echo json_encode($answer);
    }

    public function actionGetCustomer()
    {
        $data = $this->validateRequest();
        
        $cart = new StoreCart;
        $data['customer'] = $cart->getCustomer();
        $data['delivery'] = $cart->getDelivery();
        $data['payment'] = $cart->getPayment();

        echo json_encode($data);
    }

    public function actionAddToCart()
    {
        $data = $this->validateRequest();
        $answer = array();

        $cart = new StoreCart;
        $answer['error'] = $cart->addToCart($data);
        $answer['count'] = $this->getItemsInCart();


        echo json_encode($answer);
    }

    public function actionDeleteFromCart()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = '-1';

        $cart = new StoreCart;
        if ($cart->deleteFromCart($data))
        {
            $answer['error'] = 'no';
        }
            
        echo json_encode($answer);
    }

    public function actionSaveProduct()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = 'error in /store/product/SaveProduct';
        
        if (isset($data['oldProduct']) && isset($data['newProduct']))
        {
            $cart = new StoreCart;
            if ($cart->saveProduct($data['oldProduct'], $data['newProduct']))
            {
                $answer['error'] = 'no';
            }
        }
        
        echo json_encode($answer);
    }
    
    public function actionConfirmPromo()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = Yii::t('store', 'Пожалуйста, введите код!');
        
        if(!empty($data['promoCode']))
        {
            $cart = new StoreCart;
            $discount = $cart->confirmPromo($data['promoCode']);
            $answer['error'] = $discount['error'];
            $answer['discount'] = $discount;
        }
            
        echo json_encode($answer);
    }

    public function actionSaveCustomer()
    {
        $data = $this->validateRequest();
        $answer = array();
        $answer['error'] = Yii::t('store', 'Пожалуйста, заполните все обязательные поля!');

        if (isset($data['customer']))
        {
            $cart = new StoreCart;
            $answer['error'] = $cart->validateCustomer($data['customer']);
        }

        echo json_encode($answer);
    }

    public function actionBuy()
    {
        $data = $this->validateRequest();
        $answer = array();

        $cart = new StoreCart;
        if (!isset($data['delivery']))
            $answer['error'] = Yii::t('store', 'Укажите способ доставки');
        elseif (!isset($data['payment']))
            $answer['error'] = Yii::t('store', 'Укажите способ оплаты');
        else
        {
            $mailOrder = $cart->buy($data['customer'], $data['products'], $data['discount'], $data['delivery'], $data['payment']);
            $answer['error'] = $mailOrder['error'];
            if ($mailOrder['error'] == 'no')
            {
                if ($mailOrder['payment'] == 'Uniteller')
                {
                    $payment = Yii::app()->ut;
                    $token = sha1(Yii::app()->request->csrfToken);

                    $order['shopId'] = $payment->shopId;
                    $order['customerId'] = $mailOrder['customer_id'];
                    $order['orderId'] = $mailOrder['id'];
                    $order['amount'] = $mailOrder['total'];
                    $order['signature'] = $payment->getPaySign($order);
                    $order['return_ok'] = $this->createAbsoluteUrl('/store/product/PayUniteller') . '?result=success&token=' . $token;
                    $order['return_error'] = $this->createAbsoluteUrl('/store/product/PayUniteller') . '?result=error&token=' . $token;

                    $content = $this->renderPartial('//store/product/_bay_form',
                        array(
                            'order' => $order,
                        ), 
                        true
                    );

                    $answer['content'] = $content;
                    $answer['payment'] = $mailOrder['payment'];
                }
            }
        }
        
        echo json_encode($answer);
    }
    
    public function actionPayUniteller()
    {
        $token = Yii::app()->request->getParam('token', 0);
        $orderId = Yii::app()->request->getParam('Order_ID', 0);
        $result = Yii::app()->request->getParam('result', 0);

        if ($token and $token == sha1(Yii::app()->request->csrfToken) and $orderId)
        {
            $order = StoreOrder::model()->findByPk($orderId);
            if ($order && $order->status == 1)
            {
                $payment = Yii::app()->ut;

                $info = $payment->getCheckData($order->id);

                if (isset($info['status']))
                {
                   $data = array( 
                        "Status" => $info['status'],
                        "ApprovalCode" => $info['response_code'],
                        "BillNumber"   => $info['billnumber'] 
                    ); 
                            
                    $order->payment_data = $data;

                    $status = strtolower($data['Status']); 
                }
                else
                {   
                    $status = false;
                }
                
                if ($status != 'authorized' and $status != 'paid')
                {
                    $order->status = -1;
                    if (!isset(Yii::app()->session['itemsInCart']) || Yii::app()->session['itemsInCart'] == 0)
                    {
                        //Восстановление заказа в корзину
                        $cartList = array();
                        $itemsInCart = 0;
                        $list = StoreOrderList::model()->findAllByAttributes(array(
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
                                $itemsInCart += $item->quantity;
                            }
                        }
                        Yii::app()->session['storeCart'] = $cartList;
                        Yii::app()->session['itemsInCart'] = $itemsInCart;
                    }
                        
                    //Восстановление одноразового промо-кода
                    if (!empty($order->promo_id))
                    {
                        $promoCode = StorePromoCode::model()->findByPk($order->promo_id);
                        if ($promoCode && !$promoCode->is_multifold && $promoCode->used)
                        {
                            $promoCode->used = false;
                            $promoCode->save();
                        }
                    }
                    $order->save();
                }
                else
                {
                    $mailOrder = StoreCart::getMessageByOrder($order->id);

                    $order->status = 2;
                    MMail::order_track($mailOrder['email'], $mailOrder, $this->getLang());
                    MMail::order_track(Yii::app()->par->load('generalEmail'), $mailOrder, $this->getLang());
                    $order->save();
                    $token = sha1(Yii::app()->request->csrfToken);
                    $cacheId = 'StoreOrder' . $orderId;
                    Yii::app()->cache->set($cacheId, $mailOrder, 300);
                    $this->redirect('/store/product/order?Order_ID=' . $orderId . '&token=' . $token);
                }
            }
        }
        $this->redirect('/store');
    }
    
    public function actionOrder()
    {
        $token = Yii::app()->request->getParam('token', 0);
        $orderId = Yii::app()->request->getParam('Order_ID', 0);
        $order = StoreOrder::model()->findByPk($orderId);
        
        if ($token and $token == sha1(Yii::app()->request->csrfToken) && $order && $order->status >= 2)
        {
            $cacheId = 'StoreOrder' . $orderId;
            $mailOrder = Yii::app()->cache->get($cacheId);
            if ($mailOrder !== false)
                $this->render('order', array('order' => $mailOrder));
            else
                $this->setNotFound();
        }
        else
            $this->setNotFound();
    }
    
}
