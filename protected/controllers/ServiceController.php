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
        if (!Yii::app()->request->isPostRequest)
            $this->setBadReques();

        $error = "yes";
        $content = "";
        $data = $this->getJson();

        if (!isset($data['token']) or $data['token']!=Yii::app()->request->csrfToken)
            $this->setBadReques();

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
                $error = "no";
            }
            else
                $content = Yii::t('user', "Your email and password do not match each other. Please check them or re-store your password.");
        }

        echo json_encode(array(
            'error' => $error,
            'content' => $content,
        ));
    }

    //Выход
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
            $this->redirect("/");
        }
    }

    //Регистрация
    public function actionRegistration()
    {

        if (!Yii::app()->request->isPostRequest)
            $this->setBadReques();

        $error = "yes";
        $content = "";
        $data = $this->getJson();

        if (!isset($data['token']) or $data['token']!=Yii::app()->request->csrfToken)
            $this->setBadReques();

        if (isset($data['email']) and isset($data['password']))
        {
            $model = new RegistrationForm;
            $model->attributes = $data;

            if (isset(Yii::app()->request->cookies['service_name']) and isset(Yii::app()->request->cookies['service_id']))
            {
                $service_name = Yii::app()->request->cookies['service_name']->value;
                $service_name = $service_name . '_id';
                $model->{$service_name} = Yii::app()->request->cookies['service_id']->value;
            }

            if ($model->validate())
            {
                $model->password = Yii::app()->hasher->hashPassword($model->password);

                if ($model->save())
                {
                    $spot = Spot::model()->findByAttributes(array(
                        'code' => $model->activ_code,
                        'status' => Spot::STATUS_ACTIVATED
                    ));

                    $spot->user_id = $model->id;
                    $spot->lang = $this->getLang();
                    $spot->status = Spot::STATUS_REGISTERED;
                    $spot->save();

                    MMail::activation($model->email, $model->activkey, $this->getLang());
                    $content = Yii::t('user', "You and your first spot have been registred successfully. Please check your inbox to confirm registration.");
                    $error = "no";
                }
            }
            else
            {
                $validate_errors = $model->getErrors();
                if (isset($validate_errors['activ_code']))
                {
                    $content = Yii::t('user', "You've made a mistake in spot activation code. Please double-check it.");
                    $error = 'code';
                }
                elseif (isset($validate_errors['email']))
                {
                    $content = Yii::t('user', "User with your email has been already registred. Please use your password to sign in.");
                }
                else
                {
                    $content = Yii::t('user', "Password is too short (minimum is 5 characters).");
                }
            }
        }
        echo json_encode(array(
            'error' => $error,
            'content' => $content
        ));
    }

    //Активация учетки
    public function actionActivation()
    {
        if (Yii::app()->user->id)
        {
            $this->redirect('/');
        }

        $email = $_GET['email'];
        $activkey = $_GET['activkey'];

        if ($email && $activkey)
        {
            $model = User::model()->findByAttributes(array(
                'email' => $email
            ));
            if (isset($model->activkey) and ($model->activkey == $activkey))
            {
                $model->status = User::STATUS_VALID;

                if ($model->save())
                {

                    $identity = new SUserIdentity($model->email, $model->password);
                    $identity->authenticate();
                    $this->lastVisit();
                    Yii::app()->user->login($identity);
                    $this->redirect('/user/personal');
                }
            }
            else
                $this->render('activation', array(
                    'title' => Yii::t('user', "User activation"),
                    'content' => Yii::t('user', "Incorrect activation link")
                ));
        }
        else
            $this->render('activation', array(
                'title' => Yii::t('user', "User activation"),
                'content' => Yii::t('user', "Incorrect activation link")
            ));
    }

    //Восстановление пароля
    public function actionRecovery()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $error = "yes";
            $content = "";
            $data = $this->getJson();

            if (!isset($data['token']) or $data['token']!=Yii::app()->request->csrfToken)
                $this->setBadReques();

            if (isset($data['action']) and $data['action'] == "recovery")
            {
                $form = new RecoveryForm;
                if (isset($data['email']))
                {
                    $form->email = $data['email'];
                    if ($form->validate())
                    {
                        $user = User::model()->findByAttributes(array(
                            'email' => $form->email,
                            'status' => User::STATUS_VALID
                        ));
                        if ($user)
                        {
                            MMail::recovery($user->email, $user->activkey, $this->getLang());
                            $content = Yii::t('user', "A letter with instructions has been sent to your email address. Thank you.");
                            $error = "no";
                        }
                        else
                            $content = Yii::t('user', "This email has never been registred on Mobispot. Please make sure you use the correct one.");

                    }
                }
            }
            else if (isset($data['action']) and $data['action'] == "change")
            {
                if (isset($data['activkey']) and isset($data['email']))
                {
                    if (isset($data['password']) and isset($data['confirmPassword']))
                    {
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

                                $error = "no";
                            }
                        }
                    }
                }
            }
            echo json_encode(array(
                'error' => $error,
                'content' => $content
            ));
        }
        else
        {
            $email = ((isset($_GET['email'])) ? $_GET['email'] : '');
            $activkey = ((isset($_GET['activkey'])) ? $_GET['activkey'] : '');

            if ($email && $activkey)
            {
                $find = User::model()->findByAttributes(array(
                    'email' => $email
                ));
                if (isset($find) && $find->activkey == $activkey)
                {
                    $this->render('changepassword', array(
                        'email' => $email,
                        'activkey' => $activkey
                    ));
                }
            }
            $this->redirect('/');
        }
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

                    if ($model->validate())
                    {
                        $password = md5(sha1(time()));
                        $model->activkey = sha1(microtime() . $password);
                        $model->password = Yii::app()->hasher->hashPassword($password);

                        $model->type = User::TYPE_USER;
                        $model->status = User::STATUS_NOACTIVE;

                        $service = Yii::app()->request->cookies['service_name']->value . '_id';
                        $model->{$service} = Yii::app()->request->cookies['service_id']->value;
                        unset(Yii::app()->request->cookies['service_name']);
                        unset(Yii::app()->request->cookies['service_id']);

                        if ($model->save())
                        {
                            $spot = Spot::model()->findByAttributes(array(
                                'code' => $model->activ_code,
                                'status' => Spot::STATUS_ACTIVATED
                            ));

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
                        $authIdentity->redirectUrl = '/service/social';
                    }
                    else
                    {
                        $find = User::model()->findByAttributes(array(
                            $service . '_id' => $social_id
                        ));
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
                if (!empty($user->{$service . '_id'}))
                {
                    $user->{$service . '_id'} = '';
                    $user->save(false);
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
            else if (isset(Yii::app()->request->cookies['service_name']) and isset(Yii::app()->request->cookies['service_id']))
            {
                $service_name = Yii::app()->request->cookies['service_name'];
                $service_id = Yii::app()->request->cookies['service_id'];

                $user->{$service_name . '_id'} = $service_id;
                $user->save(false);

                unset(Yii::app()->request->cookies['service_name']);
                unset(Yii::app()->request->cookies['service_id']);
            }
        }
        $this->redirect('/user/profile');
    }

    public function setCookies($name, $value)
    {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = time() + 60 * 60;
        Yii::app()->request->cookies[$name] = $cookie;
    }

}