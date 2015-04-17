<?php

class ProductController extends MController
{

    public $layout = '//layouts/store';
    public $imagePath = '/uploads/store/product/';
    public $blockFooterScript = '<script src="/themes/mobispot/angular/app/controllers/store.js"></script>';

    
    //заглушка пока магазин недоступен
    public function beforeAction()
    {
        if (!CouponAccess::userAccess())
            $this->redirect('/');
        
        return true;
    }
    
    
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
        $data = MHttp::validateRequest();
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
        if (isset(Yii::app()->session['itemsInCart']) && (Yii::app()->session['itemsInCart'] > 0)) {
            $count = Yii::app()->session['itemsInCart'];
        }

        return $count;
    }


    public function actionGetCart()
    {
        $data = MHttp::validateRequest();
        $answer = array();

        $cart = new StoreCart;
        $answer = array();
        $answer['products'] = $cart->getStoreCart();
        $answer['discount'] = $cart->getDiscount();

        echo json_encode($answer);
    }

    public function actionGetCustomer()
    {
        $data = MHttp::validateRequest();

        $cart = new StoreCart;
        $data['customer'] = $cart->getCustomer();
        $data['delivery'] = $cart->getDelivery();
        $data['payment'] = $cart->getPayment();

        echo json_encode($data);
    }

    public function actionAddToCart()
    {
        $data = MHttp::validateRequest();
        $answer = array();

        $cart = new StoreCart;
        $answer['error'] = $cart->addToCart($data);
        $answer['count'] = $this->getItemsInCart();

        echo json_encode($answer);
    }
    
    
    public function actionAddCustomCard()
    {
        $answer = array('error' => 'yes');
        $data = MHttp::validateRequest();
        $photo_path = false;
        $logo_path = false;
        $custom_name = false;
        $position = false;
        $department = false;
        
        $db_product = StoreProduct::model()->findByPk($data['id']);
        if (!$db_product)
            MHttp::getJsonAndExit($answer);

        if (!empty($data['photo_croped']))
        {
            $photo = $data['photo_croped'];
            $photo = str_replace('data:image/png;base64,', '', $photo);
            $photo = str_replace(' ', '+', $photo);
            $photo_data = base64_decode($photo);
            $filename = 'photo_' . MImg::generateRandomString() . '.png';
            while (file_exists(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $filename))
                $filename = 'photo_' . MImg::generateRandomString() . '.png';

            if (file_put_contents(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $filename, $photo_data))
                $photo_path = Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $filename;
        }
        
        if (!empty($data['logo_croped']))
        {
            $logo = $data['logo_croped'];
            $logo = str_replace('data:image/png;base64,', '', $logo);
            $logo = str_replace(' ', '+', $logo);
            $logo_data = base64_decode($logo);
            $filename = 'logo_' . MImg::generateRandomString() . '.png';
            while (file_exists(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $filename))
                $filename = 'logo_' . MImg::generateRandomString() . '.png';

            if (file_put_contents(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $filename, $logo_data))
            {
                $logo_path = Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $filename;
                MImg::cutToProportionJpg($logo_path, $logo_path, MImg::LOGO_WIDTH, MImg::LOGO_HEIGHT);
            }
        }
        
        if (!empty($data['name']))
            $custom_name = $data['name'];
        if (!empty($data['position']))
            $position = $data['position'];
        if (!empty($data['department']))
            $department = $data['department'];
        $card = CustomCard::newCustomCard($photo_path, $logo_path, $custom_name, $position, $department, $db_product->type);

        if (!empty($photo_path))
            unlink($photo_path);
        if (!empty($logo_path))
            unlink($logo_path);
        if (!$card)
            MHttp::getJsonAndExit($answer);
        
        $cart = new StoreCart;
        $data['front_img'] = $card->img;
        $answer['error'] = $cart->addCustomCard($data);
        $answer['count'] = $this->getItemsInCart();
        echo json_encode($answer);
    }
    
    public function actionDeleteFromCart()
    {
        $data = MHttp::validateRequest();
        $answer = array();
        $answer['error'] = '-1';

        $cart = new StoreCart;
        if ($cart->deleteFromCart($data)) {
            $answer['error'] = 'no';
        }

        echo json_encode($answer);
    }

    public function actionSaveProduct()
    {
        $data = MHttp::validateRequest();
        $answer = array();
        $answer['error'] = 'error in /store/product/SaveProduct';

        if (isset($data['oldProduct']) && isset($data['newProduct'])) {
            $cart = new StoreCart;
            if ($cart->saveProduct($data['oldProduct'], $data['newProduct'])) {
                $answer['error'] = 'no';
            }
        }

        echo json_encode($answer);
    }

    public function actionConfirmPromo()
    {
        $data = MHttp::validateRequest();
        $answer = array();
        $answer['error'] = Yii::t('store', 'Please enter the code!');

        if(!empty($data['promoCode'])) {
            $cart = new StoreCart;
            $discount = $cart->confirmPromo($data['promoCode']);
            $answer['error'] = $discount['error'];
            $answer['discount'] = $discount;
        }

        echo json_encode($answer);
    }

    public function actionSaveCustomer()
    {
        $data = MHttp::validateRequest();
        $answer = array();
        $answer['error'] = Yii::t('store', 'Please complete all required fields!');

        if (isset($data['customer'])) {
            $cart = new StoreCart;
            $answer['error'] = $cart->validateCustomer($data['customer']);
        }

        echo json_encode($answer);
    }

    public function actionBuy()
    {
        $data = MHttp::validateRequest();
        $answer = array();
        
        $cart = new StoreCart;
        if (!isset($data['delivery'])) {
            $answer['error'] = Yii::t('store', 'Specify the delivery method');
            MHttp::getJsonAndExit($answer);
        }
        if (!isset($data['payment'])) {
            $answer['error'] = Yii::t('store', 'Select payment method');
            MHttp::getJsonAndExit($answer);
        }
        
        $cartOrder = $cart->buy($data['customer'], $data['products'], $data['discount'], $data['delivery'], $data['payment']);
        $answer['error'] = $cartOrder['error'];
        $answer['payment'] = $cartOrder['payment'];
        
        if ($cartOrder['error'] != 'no') {
             MHttp::getJsonAndExit($answer);
        }

        if ($cartOrder['payment'] == StoreCart::PAYMENT_BY_CARD or $cartOrder['payment'] == StoreCart::PAYMENT_BY_YM) {
            $answer['content'] = $this->renderPartial('//store/_store_ym_form',
                array(
                    'order'=>$cartOrder,
                    'successUrl'=>urlencode($this->getBaseUrl() . '/store/SuccessOrder/' . $cartOrder['id']),
                    'failUrl'=>urlencode($this->getBaseUrl() . '/store/FailedOrder/' . $cartOrder['id']),
                ),
                true
            );
            $answer['error'] = 'no';
        }
        elseif ($cartOrder['payment'] == StoreCart::PAYMENT_MAIL) {
            $order = StoreOrder::model()->findByPk($cartOrder['id']);
            $mailOrder = $order->mailOrder();
            //банковский перевод
            if (MMail::order_track(Yii::app()->params['generalEmail'], $mailOrder, Lang::getCurrentLang()))
            {
                MMail::order_track($mailOrder['email'], $mailOrder, Lang::getCurrentLang());
                
                //письма с персонализированными картами
                $customCards = $order->customCardsMailOrders($mailOrder);
                foreach($customCards as $customCard) {
                        MMail::custom_card_order($mailOrder['customer']->email, $customCard, Lang::getCurrentLang());
                        MMail::custom_card_order(Yii::app()->params['generalEmail'], $customCard, Lang::getCurrentLang());
                }
                
                $answer['message'] = Yii::t('store', 'Thank you for your purchase. Our manager will contact you soon for further transfer details.');
                $answer['error'] = 'no';
            }
        }
        
        echo json_encode($answer);
    }

    public function actionSuccessOrder()
    {
        $id_order = Yii::app()->request->getQuery('order', 0);
        $order = StoreOrder::model()->findByPk($id_order);
        
        if (!$order)
            $this->redirect('/store');
        if ($order->status != StoreOrder::STATUS_PAYMENT_WAIT)
            $this->redirect('/store');
        
        $message = Yii::t('store', 'Ваш заказ успешно оплачен. Спасибо за покупку!');
        
        $mailOrder = $order->mailOrder();
        
        if (!$mailOrder)
            $this->redirect('/store');
        MMail::order_track($mailOrder['customer']->email, $mailOrder, Lang::getCurrentLang());
        MMail::order_track(Yii::app()->params['generalEmail'], $mailOrder, Lang::getCurrentLang());
        
        //письма с персонализированными картами
        $customCards = $order->customCardsMailOrders($mailOrder);
        foreach($customCards as $customCard) {
                MMail::custom_card_order($mailOrder['customer']->email, $customCard, Lang::getCurrentLang());
                MMail::custom_card_order(Yii::app()->params['generalEmail'], $customCard, Lang::getCurrentLang());
        }
        
        $order->status = StoreOrder::STATUS_SUCCESS_REDIRECT;
        $order->save();
  
        $this->render('info', array('message'=>$message));
    }
    
    public function actionFailedOrder()
    {
        $id_order = Yii::app()->request->getQuery('order', 0);
        $order = StoreOrder::model()->findByPk($id_order);
        
        if ($order->status != StoreOrder::STATUS_PAYMENT_WAIT)
            $this->redirect('/store');
        
        $message = Yii::t('store', 'При проведении платежа возникла ошибка!');
        $order->status = StoreOrder::STATUS_CANCELED;
        $order->save();
        
        $this->render('info', array('message'=>$message));
    }
    
    /*
    public function actionOrder()
    {
        $token = Yii::app()->request->getParam('token', 0);
        $orderId = Yii::app()->request->getParam('Order_ID', 0);
        $order = StoreOrder::model()->findByPk($orderId);

        if ($token and $token == sha1(Yii::app()->request->csrfToken) && $order && $order->status >= 2) {
            $cacheId = 'StoreOrder' . $orderId;
            $mailOrder = Yii::app()->cache->get($cacheId);
            if ($mailOrder !== false)
                $this->render('order', array('order' => $mailOrder));
            else
                MHttp::setNotFound();
        } else
            MHttp::setNotFound();
    }
    */
}
