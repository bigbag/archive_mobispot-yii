<?php

class ServiceController extends MController
{
    const MAX_MAIL = 5;

    public function setFunctionLimit($cache_key, $func, $timeout=300){
        $token = Yii::app()->request->csrfToken;
        $limit = Yii::app()->cache->get($cache_key.'_limit_'.$token);
        if (!$limit) $limit = 0;

        if ($limit < self::MAX_MAIL)
        {
            $func;
            $limit++;
            Yii::app()->cache->set($cache_key.'_limit_'.$token, $limit+1 , $timeout);
            return True;
        }
        return False;
    }

    public function sendActivationMail($model)
    {
        return $this->setFunctionLimit(
                'activation_mail_limit', 
                MMail::activation($model->email, $model->activkey, $this->getLang())
            );
    }

    public function sendRecoveryMail($model)
    {
        return $this->setFunctionLimit(
                'activation_mail_limit', 
                MMail::recovery($model->email, $model->activkey, $this->getLang())
            );
    }

    //Смена текущего языка
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
                $user = User::getById(Yii::app()->user->id);
                if (isset($user))
                {
                    $user->lang = $lang;
                    $user->save(false);
                }
            }
        }
        $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
    }

    //Авторизация
    public function actionLogin()
    {
        $data = $this->validateRequest();

        $answer = array();

        $answer['error'] = "yes";
        $answer['content'] = "";

        if (isset($data['email']) and isset($data['password']))
        {

            $form = new LoginForm;

            $form->attributes = $data;
            if ($form->validate())
            {
                $identity = new UserIdentity($form->email, $form->password);
                $identity->authenticate();
                $this->lastVisit();
                Yii::app()->user->login($identity);
                $answer['error'] = "no";
            }
            else
            {
                $errors = $form->getErrors();
                
                if (isset($errors['status']))
                {
                    if ($errors['status'][0] == 0)
                    {
                        $user = User::model()->findByAttributes(array('email'=>$form->email));
                        #$user->activkey = User::getActivkey($user->password);
                        if ($user->save())
                        {
                            if ($this->sendActivationMail($user))
                                $answer['content'] = Yii::t('user', 'Ваша учетная запись не активирована. Для повторной активации вам выслано письмо.');
                            else 
                                $answer['content'] = Yii::t('user', 'Вы превысили максимальное количество попыток, попробуйте через 5 минут.');
                        }
                    }
                    else if ($errors['status'][0] == -1)
                        $answer['content'] = Yii::t('user', 'Ваша учетная запись заблокирована.');
                }
                else
                    $answer['content'] = Yii::t('user', 'У нас на сайте нет пользователя с такой парой "логин - пароль". Пожалуйста, проверьте введенные данные или воспользуйтесь функцией восстановления пароля.');
            }

        }
        echo json_encode($answer);
    }

    public function actionSocLogin()
    {
        $service = Yii::app()->request->getQuery('service');

        if (isset($service)) {
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->redirectUrl = Yii::app()->user->returnUrl;
            $authIdentity->cancelUrl = $this->createAbsoluteUrl('service/SocLogin');
            
            if ($authIdentity->authenticate()) {
                $identity = new ServiceUserIdentity($authIdentity);
                
                // Успешный вход
                if ($identity->authenticate()) {
                    // Специальный редирект с закрытием popup окна
                    $authIdentity->redirect(array('site/user'));
                }
                else {
                    // Закрываем popup окно и перенаправляем на cancelUrl
                    $authIdentity->cancel();
                }
            }
                $this->redirect(array('wallet/CheckLike'));
        }
    }
    
    //Выход с сайта
    public function actionLogout()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if (!(Yii::app()->user->isGuest))
            {
                Yii::app()->cache->get('user_' . Yii::app()->user->id);
                Yii::app()->user->logout();
                unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
                echo true;
            }
            echo false;
        }
        else
        {
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    //Регистрация
    public function actionRegistration()
    {
        $data = $this->validateRequest();
        $answer = array();

        $answer['error'] = 'code';
        $answer['content'] = Yii::t('user', "Не верный код активации.");

        if (isset($data['email']) and isset($data['password']))
        {

            $model = new RegistrationForm;
            $model->attributes = $data;

            if ($model->validate())
            {
                $spot = Spot::model()->findByAttributes(array('code' => $data['activ_code']));
                if ($spot)
                {
                    $wallet = PaymentWallet::getFreeByDiscodesId($spot->discodes_id);
                    if ($wallet)
                    {
                        $model->activkey = User::getActivkey($model->password);
                        $model->password = Yii::app()->hasher->hashPassword($model->password);

                        if ($model->save())
                        {
                            $wallet->status = PaymentWallet::STATUS_ACTIVE;
                            $wallet->user_id = $model->id;

                            if ($wallet->save() and $spot->status == Spot::STATUS_ACTIVATED)
                            {
                                $spot->user_id = $model->id;
                                $spot->lang = $this->getLang();
                                $spot->status = Spot::STATUS_REGISTERED;
                                $spot->save();
                            }

                            $this->sendActivationMail($model);
                            $answer['content'] = Yii::t('user', "На указанный вами email, было выслано письмо с инструкцией по активации учетной записи.");
                            $answer['error'] = "no";
                        }
                    }
                }
            }
            else
            {
                $validate_errors = $model->getErrors();
                if (isset($validate_errors['activ_code']))
                {
                    $answer['content'] = Yii::t('user', "Вы сделали ошибку в коде активации. Пожалуйста, проверьте его еще раз.");
                    $answer['error'] = 'code';
                }
                elseif (isset($validate_errors['email']))
                    $answer['content'] = Yii::t('user', "У нас уже есть пользователь с таким адресом электронной почты. Используйте свой пароль, чтобы войти на сайт.");
                else
                    $answer['content'] = Yii::t('user', "Пароль слишком короткий (минимум 5 символов).");
            }
        }
        echo json_encode($answer);
    }

    //Активация учетки
    public function actionActivation()
    {
        if (Yii::app()->user->id)
            $this->redirect('/');
        else
        {
            $email = $_GET['email'];
            $activkey = $_GET['activkey'];

            if ($email && $activkey)
            {
                $find = User::model()->findByAttributes(array('email' => $email));
                if (isset($find->activkey) && ($find->activkey == $activkey))
                {
                    $find->activkey = User::getActivkey($find->password);
                    $find->status = User::STATUS_VALID;
                    if ($find->save())
                    {

                        $spot = Spot::model()->findByAttributes(array(
                            'user_id' => $find->id,
                        ));

                        if ($spot)
                        {
                            $spot->status = Spot::STATUS_REGISTERED;
                            $spot->name = 'No Name';
                            $spot->lang = $this->getLang();
                            $spot->user_id = $find->id;
                            $spot->spot_type_id = Spot::TYPE_PERSONAL;

                            if ($spot->save())
                            {
                                $wallet = PaymentWallet::model()->findByAttributes(
                                        array('discodes_id' => $spot->discodes_id));

                                if ($wallet)
                                {
                                    $wallet->name = $spot->name;
                                    $wallet->status = PaymentWallet::STATUS_ACTIVE;
                                    $wallet->user_id = $find->id;
                                    $wallet->save();
                                }
                            }
                        }

                        $identity = new SUserIdentity($find->email, $find->password);
                        $identity->authenticate();
                        $this->lastVisit();
                        Yii::app()->user->login($identity);
                        $this->redirect('/wallet/');
                    }
                }
                else
                    $this->render('activation', array(
                        'title' => Yii::t('user', "Активация пользователя"),
                        'content' => Yii::t('user', "Неверная активационная ссылка.")
                    ));
            }
            else
                $this->render('activation', array(
                    'title' => Yii::t('user', "Активация пользователя"),
                    'content' => Yii::t('user', "Неверная активационная ссылка.")
                ));
        }
    }

    //Отправка письма с ссылкой для востановления пароля
    public function actionRecoveryMail()
    {
        $data = $this->validateRequest();
        $answer = array();

        $answer['error'] = "yes";
        $answer['content'] = "yes";

        $form = new RecoveryForm();
        if (isset($data['email']))
        {
            $form->email = $data['email'];
            if ($form->validate())
            {
                $user = User::model()->findByAttributes(array('email' => $form->email));
                if ($user)
                {
                    $user->activkey = User::getActivkey($user->password);
                    $user->save();
                    if ($this->sendRecoveryMail($user))
                    {
                        $answer['content'] = Yii::t('user', "На указанный вами email, было выслано письмо с инструкцией по восстановлению пароля.");
                        $answer['error'] = "no";
                    }
                    else
                        $answer['content'] = Yii::t('user', 'Вы превысили максимальное количество попыток, попробуйте через 5 минут.');                        
                }
                else
                    $answer['content'] = Yii::t('user', "У нас нет пользователя с таким адресом электронной почты. Пожалуйста, проверьте, что Вы ввели его без ошибок.");
            }
        }
        echo json_encode($answer);
    }

    //Смена пароля
    public function actionChangepassword()
    {
        $data = $this->validateRequest();
        $answer = array();

        $answer['error'] = "yes";
        $answer['content'] = "yes";

        if (isset($data['activkey']) and isset($data['email']))
        {
            if (isset($data['password']) and isset($data['confirmPassword']))
            {
                if ($data['password'] == $data['confirmPassword'])
                {
                    $user = User::model()->findByAttributes(array('email' => $data['email'], 'activkey' => $data['activkey']));
                    if ($user)
                    {
                        $user->password = Yii::app()->hasher->hashPassword($data['password']);

                        $user->activkey = User::getActivkey($data['password']);
                        $user->save(false);

                        $identity = new UserIdentity($data['email'], $data['password']);
                        $identity->authenticate();
                        $this->lastVisit();
                        Yii::app()->user->login($identity);

                        $answer['error'] = "no";
                    }
                }
            }
        }
        echo json_encode($answer);
    }

    //Отображение страницы восстановление пароля
    public function actionRecovery()
    {
        $email = ((isset($_GET['email'])) ? $_GET['email'] : false);
        $activkey = ((isset($_GET['activkey'])) ? $_GET['activkey'] : false);
        if ($email && $activkey)
        {

            $find = User::model()->findByAttributes(array('email' => $email));
            if (isset($find) && $find->activkey == $activkey)
            {
                $this->render(
                        'changepassword', array(
                    'email' => $email,
                    'activkey' => $activkey,
                ));
            }
            else $this->redirect('/');
        }
        else $this->redirect('/');
    }
}
