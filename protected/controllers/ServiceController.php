<?php

class ServiceController extends MController
{

    public $defaultAction = 'registration';

    //Смена языка
    public function actionLang($id)
    {
        $lang = $id;
        $all_lang = Lang::getLangArray();
        if (isset($all_lang[$lang])) {

            Yii::app()->session['lang'] = 'value';
            $cookie = new CHttpCookie('lang', $lang);
            $cookie->domain = '.'.Yii::app()->params['desktopHost'];
            Yii::app()->request->cookies['lang'] = $cookie;

            if (isset(Yii::app()->user->id)) {
                $user = User::model()->findByPk(Yii::app()->user->id);
                if (isset($user)) {
                    $user->lang = $lang;
                    $user->save(false);
                }
            }
        }
        $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
    }

    public function actionLogin()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "Check your email and password")
        );

        if (!isset($data['email']) or !isset($data['password']))
            MHttp::setBadRequest();

        $form = new LoginForm;
        $form->attributes = $data;
        if (!$form->validate())
            MHttp::getJsonAndExit($answer);

        User::autoLogin($form);
        if (!empty(Yii::app()->session['access_url'])) {
            $answer['access_url'] = Yii::app()->session['access_url'];
            unset(Yii::app()->session['access_url']);
        }

        $answer['error'] = "no";

        echo json_encode($answer);
    }

    public function actionLogout()
    {
        if (!Yii::app()->request->isPostRequest) {
            Spot::clearCurrentSpotView();
            Spot::clearCurrentSpot();
            Yii::app()->user->logout();
            $this->redirect("/");
        }

        if (!(Yii::app()->user->isGuest)) {
            Spot::clearCurrentSpot();
            Spot::clearCurrentSpotView();
            Yii::app()->user->logout();
            unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
        }
    }

    //Регистрация
    public function actionRegistration()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "You've made a mistake in spot activation code.")
        );

        if (!isset($data['email']) or !isset($data['password']))
            MHttp::setBadRequest();

        $model = new RegistrationForm;
        $model->attributes = $data;
        if (!$model->validate()) {
            $validate_errors = $model->getErrors();
            if (isset($validate_errors['activ_code'])) {
                $answer['content'] = Yii::t('user', "Wrong activation code");
                $answer['error'] = 'code';
            } elseif (isset($validate_errors['email'])) {
                $answer['content'] = Yii::t('user', "This email has been already used");
                $answer['error'] = 'email';
            } else
                $answer['content'] = Yii::t('user', "Password is too short (minimum is 5 characters).");

            MHttp::getJsonAndExit($answer);
        }

        $model->password = Yii::app()->hasher->hashPassword($model->password);
        if (!$model->save())
            MHttp::getJsonAndExit($answer);

        $socInfo = User::getCacheSocInfo();
        $socInfo['user_id'] = $model->id;

        if ($socInfo)
            SocToken::setToken($socInfo);

        $spot = Spot::getActivatedSpot($data['activ_code']);
        $spot->user_id = $model->id;
        $spot->lang = Lang::getCurrentLang();
        $spot->status = Spot::STATUS_REGISTERED;
        $spot->save();

        $wallet = PaymentWallet::model()->findByAttributes(
                array(
                    'discodes_id' => $spot->discodes_id,
                    'user_id' => 0,
                )
        );
        if ($wallet) {
            $wallet->status = PaymentWallet::STATUS_ACTIVE;
            $wallet->user_id = $spot->user_id;
            $wallet->save();

            SpotTroika::releaseTroikaCard($wallet, $model);
        }

        MMail::activation($model->email, $model->activkey, Lang::getCurrentLang());
        $answer['content'] = Yii::t('user', "You and your first spot have been registred successfully. Please check your inbox to confirm registration.");
        $answer['error'] = "no";
        echo json_encode($answer);
    }


    //Активация учетки
    public function actionActivation()
    {
        $title = Yii::t('user', "User activation");
        $content = Yii::t('user', "Incorrect activation link");
        if (Yii::app()->user->id)
            $this->redirect('/');

        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');

        if (!$email or !$activkey) {
            $this->render('activation', array(
                'title' => $title,
                'content' => $content
            ));
            exit;
        }

        $user = User::getByEmail($email);
        if (isset($user->activkey) and ($user->activkey == $activkey)) {
            $user->status = User::STATUS_VALID;
            if ($user->save()) {
                $identity = new SUserIdentity($user->email, $user->password);
                $identity->authenticate();
                User::lastVisit();
                Yii::app()->user->login($identity);
                $this->redirect('/spot/list/');
            }
        }

        $this->render('activation', array(
            'title' => $title,
            'content' => $content
        ));
    }

    //Восстановление пароля
    public function actionRecovery()
    {
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "Check your email and password")
        );
        $data = MHttp::validateRequest();

        if (!isset($data['email']))
            MHttp::getJsonAndExit($answer);

        $form = new RecoveryForm;
        $form->email = $data['email'];
        if ($form->validate()) {
            $user = User::getByEmail($form->email);
            if ($user and $user->status == User::STATUS_VALID) {
                MMail::recovery($user->email, $user->activkey, Lang::getCurrentLang());
                $answer['content'] = Yii::t('user', "A letter with instructions has been sent to your email address. Thank you.");
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

    //Смена пароля
    public function actionChange()
    {
        if (!Yii::app()->request->isPostRequest)
            $this->getChangePasswordPage();

        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "Error")
        );
        $data = MHttp::validateRequest();

        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');
        if (!$email or !$activkey)
            MHttp::setBadRequest();

        if (!isset($data['password']))
            MHttp::getJsonAndExit($answer);

        $user = User::model()->findByAttributes(array(
            'email' => $email,
            'activkey' => $activkey
        ));
        if (!$user)
            MHttp::getJsonAndExit($answer);

        $user->password = Yii::app()->hasher->hashPassword($data['password']);
        $user->activkey = sha1(microtime() . $data['password']);
        $user->save(false);

        User::autoLogin($user);
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    //Генерация страницы смены пароля
    public function getChangePasswordPage()
    {
        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');

        if ($email and $activkey) {
            $user = User::getByEmail($email);
            if (isset($user) and $user->activkey == $activkey) {
                $this->render('change', array(
                    'email' => $email,
                    'activkey' => $activkey
                ));
                exit;
            }
        }
        $this->redirect('/');
    }

    //Логин и регистрация через соц сети
    public function actionSocial()
    {
        $serviceName = Yii::app()->request->getQuery('service');
        $returnTo = Yii::app()->request->getQuery('return_to');
        $redirect = '/';

        if(!empty($returnTo)) {
            $returnTo = urldecode($returnTo);
            $redirect = $returnTo;
        }

        if (!isset($serviceName))
            $this->redirect($redirect);

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes)
            $this->redirect($redirect);

        $result = User::socialCheck($serviceName, $atributes['id']);
        if ($result['user'] and !$result['token']->allow_login)
            $this->redirect('/service/socialReg');

        if (!$result['user'])
            $this->redirect('/service/socialReg');

        User::autoLogin($result['user']);
        User::clearCacheSocInfo();
        if(!empty($returnTo))
            $this->redirect($returnTo);
        elseif (!empty(Yii::app()->session['access_url'])) {
            $path = Yii::app()->session['access_url'];
            unset(Yii::app()->session['access_url']);
            $this->redirect($path);
        } else
            $this->redirect('/spot/list');
    }

    //Страница регистрации через соц сети
    public function actionSocialReg()
    {
        if (Yii::app()->user->id)
            $this->redirect('/');

        $info = User::getCacheSocInfo();
        if (!$info)
            $this->redirect('/');

        $this->renderWithMobile(
            '//service/soc_reg',
            array('info' => $info),
            '//mobile/spot/soc_reg'
        );
    }

    public function actionSetFullView()
    {
        if (!MHttp::isHostMobile())
            return false;

        if (!isset(Yii::app()->request->cookies['full_view'])){
            $cookie = new CHttpCookie('full_view', true);
            $cookie->domain = '.'.Yii::app()->params['desktopHost'];
            Yii::app()->request->cookies['full_view'] = $cookie;
        }
        $this->redirect('//'.Yii::app()->params['desktopHost']);
    }

    // Привязка и отвязка соц сетей
    public function actionSocialConnect()
    {
        if (!isset(Yii::app()->user->id))
            $this->redirect('/');

        $user = User::model()->findByPk(Yii::app()->user->id);
        if (!$user)
            $this->redirect('/');

        $serviceName = Yii::app()->request->getQuery('service');
        if (!$serviceName)
            $this->redirect('/user/profile');

        $userToken = SocToken::model()->findByAttributes(array(
            'type' => SocToken::getTypeByService($serviceName),
            'user_id' => $user->id,
        ));

        if ($userToken and !empty($userToken->soc_id) and $userToken->allow_login) {
            $userToken->allow_login = false;
            $userToken->save();
            $this->redirect('/user/profile');
        }

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes)
            $this->redirect('/user/profile');

        SocToken::setToken($atributes);
        User::clearCacheSocInfo();

        $userToken = SocToken::model()->findByAttributes(array(
            'type' => SocToken::getTypeByService($serviceName),
            'user_id' => $user->id,
        ));

        if ($userToken and !empty($userToken->soc_id) and !$userToken->allow_login) {
            $userToken->allow_login = true;
            $userToken->save();
            $this->redirect('/user/profile');
        }

        $this->redirect('/user/profile');
    }

    //Отсылка вопроса
    public function actionSendQuestion()
    {
        $data = MHttp::validateRequest();
        $answer = array('error' => "yes", "content" => "");

        if (!isset($data['email']) or !isset($data['name']) or !isset($data['question'])) {
            MHttp::getJsonAndExit($answer);
        }

        $recipients = Yii::app()->params['questionMail'];
        MMail::question($recipients, $data, Lang::getCurrentLang());

        $answer['content'] = Yii::t('help', 'Question has been submitted');
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    public function actionBuyDemoKit()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => 'yes',
            'content' => '',
            'message'=>Yii::t('store', 'Error! Check the correctness of filling in the order.')
            );

        /*
        if (empty($data['products']))
            MHttp::getJsonAndExit($answer);
        */
        $config = DemoKitOrder::getConfig();
        $order = DemoKitOrder::fromArray($data);

        if(!$order->save()) {
            $answer['message'] = '';
            $errors = $order->getErrors();
            foreach ($errors as $field=>$error)
                foreach ($error as $message)
                    $answer['message'] .= $message . ' ';
            MHttp::getJsonAndExit($answer);
        }

        $payment = DemoKitOrder::getPayment($order->payment);
        $answer['action'] = $payment['action'];

        //письмо покупателю
        $mailOrder = $order->makeMailOrder();
        if (!MMail::demokit_order($mailOrder['email'], $mailOrder, Lang::getCurrentLang()))
            MHttp::getJsonAndExit($answer);

        if ($payment['action'] == DemoKitOrder::PAYMENT_BY_CARD or 
                $payment['action'] == DemoKitOrder::PAYMENT_BY_YM) {

            $order->total = $order->getSummRub();
            $order->customer_id = $order->id;
            $order->details = Yii::t('store', 'Demo kit Mobispot');
            
            $answer['content'] = $this->renderPartial('//store/_ym_form',
                array(
                    'order'=>$order,
                    'action'=>$payment['action'],
                    'successUrl'=>urlencode(MHttp::desktopHost()),
                    'failUrl'=>urlencode(MHttp::desktopHost()),
                ),
                true
            );
            $answer['error'] = 'no';
        } elseif ($payment['action'] == DemoKitOrder::PAYMENT_MAIL) {
            //банковский перевод, письмо админу
            if (MMail::demokit_order(Yii::app()->params['generalEmail'], $mailOrder, Lang::getCurrentLang())
            )
            {
                $answer['message'] = $config['mailOrderMessage'];
                $answer['error'] = 'no';
            }
        }

        echo json_encode($answer);
    }

    public function setCookies($name, $value)
    {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = time() + 60 * 60;
        Yii::app()->request->cookies[$name] = $cookie;
    }

}
