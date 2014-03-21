<?php

class ServiceController extends MController
{

    public $defaultAction = 'registration';

    //Смена языка
    public function actionLang($id)
    {
        $lang = $id;
        $all_lang = Lang::getLangArray();
        if (isset($all_lang[$lang]))
        {

            Yii::app()->session['lang'] = 'value';
            Yii::app()->request->cookies['lang'] = new CHttpCookie('lang', $lang);

            if (isset(Yii::app()->user->id))
            {
                $user = User::model()->findByPk(Yii::app()->user->id);
                if (isset($user))
                {
                    $user->lang = $lang;
                    $user->save(false);
                }
            }
        }
        $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
    }

    //Автологин
    public function autoLogin($user)
    {
        $identity = new SUserIdentity($user->email, $user->password);
        $identity->authenticate();
        $this->lastVisit();
        return Yii::app()->user->login($identity);
    }

    //Авторизация
    public function actionLogin()
    {
        $data = $this->validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "Check your email and password")
        );

        if (!isset($data['email']) or !isset($data['password']))
            $this->setBadRequest();

        $form = new LoginForm;
        $form->attributes = $data;
        if (!$form->validate())
            $this->getJsonAndExit($answer);

        $this->autoLogin($form);
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    //Выход
    public function actionLogout()
    {
        if (!Yii::app()->request->isPostRequest)
        {
            Yii::app()->user->logout();
            $this->redirect("/");
        }

        if (!(Yii::app()->user->isGuest))
        {
            Yii::app()->cache->get('user_' . Yii::app()->user->id);
            Yii::app()->user->logout();
            unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
        }
    }

    //Регистрация
    public function actionRegistration()
    {

        $data = $this->validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "You've made a mistake in spot activation code.")
        );

        if (!isset($data['email']) or !isset($data['password']))
            $this->setBadRequest();

        $model = new RegistrationForm;
        $model->attributes = $data;
        if (!$model->validate())
        {
            $validate_errors = $model->getErrors();
            if (isset($validate_errors['activ_code']))
            {
                $answer['content'] = Yii::t('user', "Wrong activation code");
                $answer['error'] = 'code';
            }
            elseif (isset($validate_errors['email']))
            {
                $answer['content'] = Yii::t('user', "This email has been already used");
                $answer['error'] = 'email';
            }
            else
                $answer['content'] = Yii::t('user', "Password is too short (minimum is 5 characters).");

            $this->getJsonAndExit($answer);
        }

        $model->password = Yii::app()->hasher->hashPassword($model->password);
        if (!$model->save())
            $this->getJsonAndExit($answer);

        $socInfo = User::getCacheSocInfo();
        $socInfop['user_id'] = $model->id;
        if ($socInfo)
            SocToken::setToken($socInfo);

        $spot = Spot::getActivatedSpot($data['activ_code']);
        $spot->user_id = $model->id;
        $spot->lang = $this->getLang();
        $spot->status = Spot::STATUS_REGISTERED;
        $spot->save();

        $wallet = PaymentWallet::model()->findByAttributes(
                array(
                    'discodes_id' => $spot->discodes_id,
                    'user_id' => 0,
                )
        );
        if ($wallet)
        {
            $wallet->status = PaymentWallet::STATUS_ACTIVE;
            $wallet->user_id = $spot->user_id;
            $wallet->save();
        }

        MMail::activation($model->email, $model->activkey, $this->getLang());
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
        {
            $this->redirect('/');
        }

        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');

        if (!$email or !$activkey)
        {
            $this->render('activation', array(
                'title' => $title,
                'content' => $content
            ));
            exit;
        }

        $user = User::getByEmail($email);
        if (isset($user->activkey) and ($user->activkey == $activkey))
        {
            $user->status = User::STATUS_VALID;
            if ($user->save())
            {
                $identity = new SUserIdentity($user->email, $user->password);
                $identity->authenticate();
                $this->lastVisit();
                Yii::app()->user->login($identity);
                $this->redirect('/user/personal');
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
        $data = $this->validateRequest();

        if (!isset($data['email']))
            $this->getJsonAndExit($answer);

        $form = new RecoveryForm;
        $form->email = $data['email'];
        if ($form->validate())
        {
            $user = User::getByEmail($form->email);
            if ($user and $user->status == User::STATUS_VALID)
            {
                MMail::recovery($user->email, $user->activkey, $this->getLang());
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
        $data = $this->validateRequest();

        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');
        if (!$email or !$activkey)
            $this->setBadRequest();

        if (!isset($data['password']))
            $this->getJsonAndExit($answer);

        $user = User::model()->findByAttributes(array(
            'email' => $email,
            'activkey' => $activkey
        ));
        if ($user)
        {
            $user->password = Yii::app()->hasher->hashPassword($data['password']);
            $user->activkey = sha1(microtime() . $data['password']);
            $user->save(false);

            $identity = new UserIdentity($email, $data['password']);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);

            $answer['error'] = "no";
        }

        echo json_encode($answer);
    }

    //Генерация страницы смены пароля
    public function getChangePasswordPage()
    {
        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');

        if ($email and $activkey)
        {
            $user = User::getByEmail($email);
            if (isset($user) and $user->activkey == $activkey)
            {
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
        Yii::log('AuthException', 'error', 'application');
        $serviceName = Yii::app()->request->getQuery('service');
        if (!isset($serviceName))
            $this->redirect('/');

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes)
            $this->redirect('/');

        $result = User::socialCheck($serviceName, $atributes['id']);
        if ($result['user'] and !$result['token']->allow_login)
            $this->redirect('/');

        if (!$result['user'])
            $this->redirect('/service/socialReg');

        $this->autoLogin($result['user']);
        User::clearCacheSocInfo();
        $this->redirect('/user/personal');
    }

    //Страница регистрации через соц сети
    public function actionSocialReg()
    {
        if (Yii::app()->user->id)
            $this->redirect('/');

        $info = User::getCacheSocInfo();
        if (!$info)
            $this->redirect('/');

        $this->render('soc_reg', array('info' => $info));
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

        if ($userToken and !empty($userToken->soc_id))
        {
            $userToken->allow_login = !$userToken->allow_login;
            $userToken->save();
            $this->redirect('/user/profile');
        }

        $atributes = User::getSocInfo($serviceName);
        if (!$atributes)
            $this->redirect('/user/profile');

        $socInfo = User::getCacheSocInfo();
        if ($socInfo)
        {
            SocToken::setToken($atributes);
            User::clearCacheSocInfo();

            $allSocTokens = SocToken::model()->findAllByAttributes(
                    array(
                        'type' => SocToken::getTypeByService($serviceName),
                        'soc_id' => $socInfo['id'],
                    )
            );

            foreach ($allSocTokens as $row)
            {
                if ($row->user_id != $user->id)
                    $row->delete();
            }
        }
        $this->redirect('/user/profile');
    }

    //Отсылка вопроса
    public function actionSendQuestion()
    {
        $data = $this->validateRequest();
        $answer = array('error' => "yes", "content" => "");

        if (!isset($data['email']) or !isset($data['name']) or !isset($data['question']))
        {
            $this->getJsonAndExit($answer);
        }

        $recipients = array('ilya.radaev@gmail.com', 'alex.kulagin@mobispot.com', 'volgin@mobispot.com');

        MMail::question($recipients, $data, $this->getLang());
        $answer['content'] = Yii::t('help', 'Question has been submitted');
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    public function setCookies($name, $value)
    {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = time() + 60 * 60;
        Yii::app()->request->cookies[$name] = $cookie;
    }

}
