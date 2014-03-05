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

    //Авторизация
    public function actionLogin()
    {
        $data = $this->validateRequest();
        $answer = array(
            'error'=>"yes", 
            "content" => Yii::t('user', "Check your email and password")
        );

        if (!isset($data['email']) or !isset($data['password']))
            $this->setBadRequest();

        $form = new LoginForm;
        $form->attributes = $data;
        if (!$form->validate())
        {
            echo json_encode($answer);
            exit;
        }

        $identity = new UserIdentity($form->email, $form->password);
        $identity->authenticate();
        $this->lastVisit();
        Yii::app()->user->login($identity);
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
            'error'=>"yes", 
            "content" => Yii::t('user', "You've made a mistake in spot activation code.")
        );

        if (!isset($data['email']) or !isset($data['password'])) 
            $this->setBadRequest();
            
        $model = new RegistrationForm;
        $model->attributes = $data;

        if (isset(Yii::app()->request->cookies['service_name']) and isset(Yii::app()->request->cookies['service_id']))
        {
            $service_name = Yii::app()->request->cookies['service_name']->value;
            $service_name = $service_name . '_id';
            $model->{$service_name} = Yii::app()->request->cookies['service_id']->value;
        }

        if (!$model->validate())
        {
            $validate_errors = $model->getErrors();
            if (isset($validate_errors['activ_code']))
            {
                $answer['content'] = Yii::t('user', "You`ve made a mistake in spot activation code.");
                $answer['error'] = 'code';
            }
            elseif (isset($validate_errors['email']))
            {
                $answer['content'] = Yii::t('user', "User with your email has been already registred. Please use your password to sign in.");
                $answer['error'] = 'email';
            }
            else
            {
                $answer['content'] = Yii::t('user', "Password is too short (minimum is 5 characters).");
            }
            echo json_encode($answer);
            exit;
        }

        $model->password = Yii::app()->hasher->hashPassword($model->password);
        if (!$model->save())
        {
            echo json_encode($answer);
            exit;
        }

        $spot = Spot::model()->findByAttributes(
            array(
                'code'=>$data['activ_code'], 
                'status' => Spot::STATUS_ACTIVATED
                )
            );
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
            'error'=>"yes", 
            "content" => Yii::t('user', "Error")
        );
        $data = $this->validateRequest();

        if (!isset($data['email']))
        {
            echo json_encode($answer);
            exit;
        }
        
        $form = new RecoveryForm;
        $form->email = $data['email'];
        if ($form->validate())
        {
            $user = User::getByEmail($form->email);
            if (!$user or $user->status!=User::STATUS_VALID)
                $answer['content'] = Yii::t('user', "Check your email and password");
            else 
            {
                MMail::recovery($user->email, $user->activkey, $this->getLang());
                $answer['content'] = Yii::t('user', "A letter with instructions has been sent to your email address. Thank you.");
                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

    //Страница смены пароля
    public function actionChange()
    {
        if (!Yii::app()->request->isPostRequest)
            $this->getChangePage();

        $answer = array(
            'error'=>"yes", 
            "content" => Yii::t('user', "Error")
        );
        $data = $this->validateRequest();

        if (!isset($data['activkey']) or !isset($data['email']))
        {
            echo json_encode($answer);
            exit;
        }

        if (!isset($data['password']) or !isset($data['confirmPassword']))
        {
            echo json_encode($answer);
            exit;
        }

        if ($data['password'] == $data['confirmPassword'])
        {
            $user = User::model()->findByAttributes(array(
                'email' => $data['email'],
                'activkey' => $data['activkey']
            ));

            if ($user)
            {
                $user->password = Yii::app()->hasher->hashPassword($data['password']);
                $user->activkey = sha1(microtime() . $data['password']);
                $user->save(false);

                $identity = new UserIdentity($data['email'], $data['password']);
                $identity->authenticate();
                $this->lastVisit();
                Yii::app()->user->login($identity);

                $answer['error'] = "no";
            }
        }
        echo json_encode($answer);
    }

    public function getChangePage()
    {
        $email = Yii::app()->request->getParam('email');
        $activkey = Yii::app()->request->getParam('activkey');

        if ($email and $activkey)
        {
            $user = User::getByEmail($email);
            if (isset($user) && $user->activkey == $activkey)
            {
                $this->render('changepassword', array(
                    'email' => $email,
                    'activkey' => $activkey
                ));
                exit;
            }
        }
        $this->redirect('/');
    }

    // Регистрация через соц сети
    public function actionSocial()
    {
        $service = Yii::app()->request->getQuery('service');
        $denied = Yii::app()->request->getQuery('denied');
        $error = Yii::app()->request->getQuery('error');

        if (Yii::app()->request->isPostRequest)
        {
            $error = "yes";
            $content = "";
            $data = $this->getJson();

            if (!isset($data['token']) or $data['token']!=Yii::app()->request->csrfToken)
                $this->setBadReques();

            if (isset($data['email']))
            {
                $user = User::model()->findByAttributes(array(
                    'email' => $data['email']
                ));

                if (!$user)
                {
                    $model = new RegistrationSocialForm;
                    $model->attributes = $data;
                    
                    $spot = Spot::getActivatedSpot($model->activ_code);
                    if ($spot)
                    {
                        if ($model->validate())
                        {
                            $password = md5(sha1(time()));
                            $model->activkey = sha1(microtime() . $password);
                            $model->password = Yii::app()->hasher->hashPassword($password);

                            $model->type = User::TYPE_USER;
                            $model->status = User::STATUS_NOACTIVE;

                            $service = Yii::app()->request->cookies['service_name']->value;
                            $soc_id = Yii::app()->request->cookies['service_id']->value;
                            
                            unset(Yii::app()->request->cookies['service_name']);
                            unset(Yii::app()->request->cookies['service_id']);

                            if ($model->save())
                            {
                                $userToken = SocToken::model()->findByAttributes(array(
                                    'type' => SocToken::getTypeByService($service),
                                    'soc_id' => $soc_id,
                                ));
                                
                                if(!$userToken)
                                    $userToken = new SocToken;
                                
                                $userToken->type = SocToken::getTypeByService($service);
                                $userToken->user_id = $model->id;
                                $userToken->soc_id = $soc_id;
                                $userToken->allow_login = true;
                                $userToken->save();
                                
                                $spot->user_id = $model->id;
                                $spot->status = Spot::STATUS_REGISTERED;
                                $spot->save();

                                MMail::activation($model->email, $model->activkey, $this->getLang());

                                $error = "no";
                                $content = Yii::t('user', "You and your first spot have been registred successfully. Please check your inbox to confirm registration. ");
                            }
                        }
                    }
                    else
                    {
                        $error = "code";
                        $content = Yii::t('user', "Код активации спота неверен");
                    }
                }
                else
                {
                    $error = "email";
                    $content = Yii::t('user', "You email is busy");
                }
            }

            echo json_encode(array(
                'error' => $error,
                'content' => $content
            ));
        }
        else if (isset($denied) or isset($error))
        {
            $this->redirect('/');
        }
        else if (isset($service))
        {
            $authIdentity = Yii::app()->eauth->getIdentity($service);
            $authIdentity->cancelUrl = '/user/personal';

            if ($authIdentity->authenticate())
            {
                $identity = new CEAuthUserIdentity($authIdentity);

                if ($identity->authenticate())
                {

                    $social_id = $identity->getId();
                    $service_email = $identity->getState('email', '');

                    if (!User::socialCheck($service, $social_id))
                    {
                        $this->setCookies('service_name', $service);
                        $this->setCookies('service_id', $social_id);
                        $this->setCookies('service_email', $service_email);
                        //$authIdentity->redirectUrl = '/service/social';
                        unset(Yii::app()->session['__eauth_' . $service . '__auth_token']);
                        $authIdentity->redirect(array('service/social'));
                    }
                    else
                    {
                        $userToken = SocToken::model()->findByAttributes(array(
                            'type' => SocToken::getTypeByService($service),
                            'soc_id' => $social_id,
                            'allow_login' => true
                        ));
                        
                        $find = User::model()->findByPk($userToken->user_id);
                        $identity = new SUserIdentity($find->email, $find->password);
                        $identity->authenticate();
                        $this->lastVisit();

                        unset(Yii::app()->request->cookies['service_name']);
                        unset(Yii::app()->request->cookies['service_id']);

                        Yii::app()->user->login($identity);
                        $this->redirect('/user/personal');
                    }
                    $this->redirect('/');
                }
                else
                {
                    $this->redirect('/user/personal');
                }
            }
            $this->redirect('/');
        }
        else
        {
            if (isset(Yii::app()->request->cookies['service_name']) and isset(Yii::app()->request->cookies['service_id']))
            {
                $email = '';

                if (!empty(Yii::app()->request->cookies['service_email']->value))
                {
                    $email = Yii::app()->request->cookies['service_email']->value;
                }

                $this->render('social', array(
                    'service' => Yii::app()->request->cookies['service_name'],
                    'email' => $email
                ));
            }
            else
            {
                $this->redirect('/');
            }
        }
    }

    // Привязка и отвязка соц сетей
    public function actionSocialConnect()
    {
        $service = Yii::app()->request->getQuery('service');
        $denied = Yii::app()->request->getQuery('denied');
        $error = Yii::app()->request->getQuery('error');

        if (!isset(Yii::app()->user->id))
            $this->redirect('/');

        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user)
        {
            if (isset($denied) or isset($error))
            {
                $this->redirect('/user/profile');
            }
            else if (isset($service))
            {
                $userToken = SocToken::model()->findByAttributes(array(
                    'type' => SocToken::getTypeByService($service),
                    'user_id' => $user->id,
                ));

                if ($userToken && $userToken->allow_login && !empty($userToken->soc_id))
                {
                    $userToken->allow_login = false;
                    $userToken->save();
                }
                else
                {
                    $authIdentity = Yii::app()->eauth->getIdentity($service);

                    if ($authIdentity->authenticate())
                    {
                        $identity = new CEAuthUserIdentity($authIdentity);

                        if ($identity->authenticate())
                        {

                            $social_id = $identity->getId();
                            $this->setCookies('service_name', $service);
                            $this->setCookies('service_id', $social_id);
                            $authIdentity->redirectUrl = '/user/profile';
                        }
                        else
                        {
                            $this->redirect('/user/profile');
                        }
                    }
                    $this->redirect('/service/socialConnect');
                }
            }
            elseif (isset(Yii::app()->request->cookies['service_name']) and isset(Yii::app()->request->cookies['service_id']))
            {
                $service_name = Yii::app()->request->cookies['service_name'];
                $service_id = Yii::app()->request->cookies['service_id'];

                $userToken = SocToken::model()->findByAttributes(array(
                    'type' => SocToken::getTypeByService($service_name),
                    'user_id' => $user->id,
                ));
                
                if (!$userToken)
                {
                    $userToken = new SocToken;
                    $userToken->type = SocToken::getTypeByService($service_name);
                    $userToken->user_id = $user->id;
                }
                
                $userToken->soc_id = $service_id;
                $userToken->allow_login = true;
                $userToken->save();
                
                //удаление старой привязки с другого аккаунта mobispot к той же соцсети
                $allSocTokens = SocToken::model()->findAllByAttributes(array(
                    'type' => SocToken::getTypeByService($service_name),
                    'soc_id' => $service_id,
                ));

                foreach ($allSocTokens as $sToken)
                {
                    if ($sToken->user_id != $user->id)
                        $sToken->delete();
                }
                
                unset(Yii::app()->request->cookies['service_name']);
                unset(Yii::app()->request->cookies['service_id']);
            }
        }
        $this->redirect('/user/profile');
    }

     //Отсылка вопроса
    public function actionSendQuestion()
    {
        $data = $this->validateRequest();
        $answer = array('error'=>"yes", "content" => "");

        if (!isset($data['email']) or !isset($data['name']) or !isset($data['question']))
        {
            echo json_encode($answer);
            exit;
        }
        
        MMail::question(Yii::app()->par->load('generalEmail'), $data, $this->getLang());
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