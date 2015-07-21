<?php

class ProductController extends MController
{

    public $layout = '//layouts/store';
    public $imagePath = '/uploads/store/product/';
    public $blockFooterScript = '<script src="/themes/mobispot/angular/app/controllers/store.js"></script>';

    //заглушка пока магазин недоступен
    // public function beforeAction()
    // {
    //     if (!CouponAccess::userAccess())
    //         $this->redirect('/');

    //     return true;
    // }


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
        $this->render('cart', array('imagePath' => $this->imagePath));
    }

    public function actionGetPriceList()
    {
        $cart = new StoreCart;
        echo json_encode(
            array(
                'products' => $cart->getPriceList(),
                'settings' => array(
                    'addToCart' => Yii::t('store', 'Add to cart'),
                    'added' => Yii::t('store', 'Added')
                )
            )
        );
    }


    public function getItemsInCart()
    {
        $count = 0;
        $cart = new StoreCart; //для проверки в конструкторе Cart - если юзер залогинился
        if (isset(Yii::app()->session['itemsInCart'])
                && (Yii::app()->session['itemsInCart'] > 0)) {
            $count = Yii::app()->session['itemsInCart'];
        }

        return $count;
    }


    public function actionGetCart()
    {
        $cart = new StoreCart;
        echo json_encode(
            array(
                'products' => $cart->getStoreCart(),
                'discount' => $cart->getDiscount()
            )
        );
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
        $cart = new StoreCart;
        echo json_encode(
            array(
                'error' => $cart->addToCart(MHttp::validateRequest()),
                'count' => $this->getItemsInCart()
            )
        );
    }

    public function saveCropImage($photo, $prefix)
    {
        $photo = str_replace('data:image/png;base64,', '', $photo);
        $photo = str_replace(' ', '+', $photo);

        $photo_data = base64_decode($photo);
        $file_name = MImg::getRandomFileName($prefix, 'png');
        while (file_exists(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $file_name))
            $file_name = MImg::getRandomFileName($prefix, 'png');
        
        $file_patch = Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $file_name;

        if (!file_put_contents($file_patch, $photo_data))
            return false;
        
        return $file_name;
    }

    public function actionAddCustomCard()
    {
        $answer = array('error' => 'yes');
        $data = MHttp::validateRequest();

        $photo = false;
        $photo_croped = false;
        $logo = false;
        $logo_croped = false;

        $db_product = StoreProduct::model()->findByPk($data['id']);
        if (!$db_product)
            MHttp::getJsonAndExit($answer);

        if (!empty($data['photo_croped']) and !empty($data['photo'])) {
            $photo = $this->saveCropImage($data['photo'], 'photo');
            $photo_croped = $this->saveCropImage($data['photo_croped'], 'photo');
        }

        if (!empty($data['logo_croped']) and !empty($data['logo'])) {
            $logo_croped = $this->saveCropImage($data['logo_croped'], 'logo');
            if ($logo_croped) {
                MImg::cutToProportionJpg(
                    Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $logo_croped,
                    Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $logo_croped,
                    MImg::LOGO_WIDTH,
                    MImg::LOGO_HEIGHT
                );
            }
            
            $logo = $this->saveCropImage($data['logo'], 'logo');
        }
        
        if (!empty($data['design_croped'])){
            $user_design_file = $this->saveCropImage($data['design_croped'], 'transport_', true);
            $card = CustomCard::newUserDesignedCard($user_design_file);
        }
        else
        {
            $card = CustomCard::newCustomCard(
                    $photo,
                    $photo_croped,
                    $logo,
                    $logo_croped,
                    (!empty($data['name'])) ? $data['name'] : false,
                    (!empty($data['position'])) ? $data['position'] : false,
                    (!empty($data['department'])) ? $data['department'] : false,
                    $db_product->type
                );
        }
        
        if (!empty($photo_croped))
            unlink(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $photo_croped);
        if (!empty($logo_croped))
            unlink(Yii::getPathOfAlias('webroot.uploads.custom_card') . '/' . $logo_croped);
        
        if (!$card)
            MHttp::getJsonAndExit($answer);
        
        $cart = new StoreCart;
        $data['custom_card'] = $card;

        echo json_encode(
            array(
                'error' => $cart->addCustomCard($data),
                'count' => $this->getItemsInCart()
            )
        );
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
        $answer = array('error' => 'error in /store/product/SaveProduct');

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
        $answer = array('error' => Yii::t('store', 'Please enter the code!'));

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
        $answer = array('error' => Yii::t('store', 'Please complete all required fields!'));

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

        $order = $cart->buy($data['customer'],
                            $data['products'],
                            $data['discount'],
                            $data['delivery'],
                            $data['payment']);

        $answer['error'] = $order['error'];
        if (!empty($order['payment']))
            $answer['payment'] = $order['payment'];

        if ($order['error'] != 'no') {
             MHttp::getJsonAndExit($answer);
        }

        if ($order['payment'] == StoreCart::PAYMENT_BY_CARD or
                $order['payment'] == StoreCart::PAYMENT_BY_YM) {

            $object_order = (object) $order;
            $object_order->name = $order['target_first_name'] . ' ' . $order['target_last_name'];
            $object_order->details = Yii::t('store', 'Mobispot');
            $object_order->total = 10;

            $answer['content'] = $this->renderPartial('//store/_ym_form',
                array(
                    'order'=>$object_order,
                    'action'=>$order['payment'],
                    'successUrl'=>$this->getBaseUrl() . '/store/SuccessOrder/' . $order['id'],
                    'failUrl'=>$this->getBaseUrl() . '/store/FailedOrder/' . $order['id'],
                ),
                true
            );
            $answer['error'] = 'no';
        } elseif ($order['payment'] == StoreCart::PAYMENT_MAIL) {
            $order = StoreOrder::model()->findByPk($order['id']);
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
        $order = StoreOrder::model()->findByPk(
            Yii::app()->request->getQuery('order', 0));

        if (!$order)
            $this->redirect('/store');
        if ($order->status != StoreOrder::STATUS_PAYMENT_WAIT)
            $this->redirect('/store');

        $message = Yii::t('store', 'При регистрации пользователя возникла ошибка!');

        $mailOrder = $order->mailOrder();
        if (!$mailOrder)
            $this->redirect('/store');

        $user_id = $order->registerUser(Lang::getCurrentLang());
        $user = User::model()->findByPk($user_id);
        if (!$user){
            $this->render('info', array('message'=>$message));
            Yii::app()->end();
        }

        if (User::STATUS_NOACTIVE == $user->status)
            MMail::activation($user->email, $user->activkey, Lang::getCurrentLang());

        $order->status = StoreOrder::STATUS_SUCCESS_REDIRECT;
        if (!$order->save()){
            $this->render('info', array('message'=>$message));
            Yii::app()->end();
        }

        $message = Yii::t('store', 'Ваш заказ успешно оплачен. Спасибо за покупку!');

        MMail::order_track($mailOrder['customer']->email, $mailOrder, Lang::getCurrentLang());
        MMail::order_track(Yii::app()->params['generalEmail'], $mailOrder, Lang::getCurrentLang());

        //письма с персонализированными картами
        $customCards = $order->customCardsMailOrders($mailOrder);
        foreach($customCards as $customCard) {
                MMail::custom_card_order($mailOrder['customer']->email, $customCard, Lang::getCurrentLang());
                MMail::custom_card_order(Yii::app()->params['generalEmail'], $customCard, Lang::getCurrentLang());
        }

        $order->makeTroika($user_id);

        $this->render('info', array('message'=>$message));
    }

    public function actionFailedOrder()
    {
        $order = StoreOrder::model()->findByPk(
            Yii::app()->request->getQuery('order', 0));

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
