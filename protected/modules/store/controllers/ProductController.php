<?php

class ProductController extends MController
{

    public $layout = '//layouts/store';
    public $imagePath = '/uploads/store/product/';

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
            if (isset($data['token']) and $data['token'] == Yii::app()->request->csrfToken && isset($data['customer']) && isset($data['products']) && isset($data['delivery']) && isset($data['payment']))
            {
                $cart = new Cart;
                $mailOrder = $cart->buy($data['customer'], $data['products'], $data['delivery'], $data['payment']);
                $answer['error'] = $mailOrder['error'];
                if ($mailOrder['error'] == 'no')
                {
                    MMail::order_track($mailOrder['email'], $mailOrder, $this->getLang());
                }
            }
            echo CJSON::encode($answer);
        }
        Yii::app()->end();
    }

}
