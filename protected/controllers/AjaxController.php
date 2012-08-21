<?php

class AjaxController extends MController
{
    public function filters()
    {
        return array(
            'ajaxOnly',
        );
    }

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'application.extensions.kcaptcha.KCaptchaAction',
                'maxLength' => 6,
                'minLength' => 5,
                'foreColor' => array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100)),
                'backColor' => array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
            ),
        );
    }

    public function actionLogin()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                if (isset(Yii::app()->session['login_error_count'])) {
                    $login_error_count = Yii::app()->session['login_error_count'];
                } else $login_error_count = 0;

                if ($login_error_count > 1) {
                    echo 'login_error_count';
                } else {
                    $form = new LoginForm;
                    if (isset($_POST['LoginForm'])) {
                        $form->attributes = $_POST['LoginForm'];
                        $form->rememberMe = true;
                        if ($form->validate()) {
                            $identity = new UserIdentity($form->email, $form->password);
                            $identity->authenticate();
                            $this->lastVisit();
                            unset(Yii::app()->session['login_error_count']);
                            echo true;
                        } else {
                            if ($form->getErrors()) {
                                Yii::app()->session['login_error_count'] = $login_error_count + 1;
                                $error = $form->getErrors();
                                if (isset($error['password'])) echo 'password_error';
                                else if (isset($error['email'])) echo 'email_error';
                            }
                        }
                    } else echo false;
                }
            }
        }
    }

    public function actionLoginCaptcha()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                $form = new LoginCaptchaForm();
                if (isset($_POST['LoginCaptchaForm'])) {
                    $form->attributes = $_POST['LoginCaptchaForm'];
                    if ($form->rememberMe == 'on') $form->rememberMe = 1;
                    else $form->rememberMe = 0;
                    if ($form->validate()) {
                        $identity = new UserIdentity($form->email, $form->password);
                        $identity->authenticate();
                        $this->lastVisit();
                        unset(Yii::app()->session['login_error_count']);
                        echo true;
                    } else {
                        //echo json_encode(array('error' => $form->getErrors()));
                        echo false;
                    }
                }
            }
        }
    }


    public function actionLogout()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!(Yii::app()->user->isGuest)) {
                Yii::app()->cache->get('user_' . Yii::app()->user->id);
                Yii::app()->user->logout();
                unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
                echo true;
            }
            echo false;
        }
    }

    public function actionRecovery()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                $form = new RecoveryForm;
                if (isset($_POST['email'])) {
                    $form->email = $_POST['email'];
                    if ($form->validate()) {
                        $user = User::model()->findByAttributes(array('email' => $form->email));
                        MMail::recovery($user->email, $user->activkey);

                        echo true;
                    } else echo false;
                }
            }
        }
    }

    public
    function actionRegistration()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                if (isset(Yii::app()->session['registration_error_count'])) {
                    $registration_error_count = Yii::app()->session['registration_error_count'];
                } else $registration_error_count = 0;

                if ($registration_error_count == 0) $model = new RegistrationForm;
                else $model = new RegistrationCaptchaForm;

                if (isset($_POST['RegistrationForm'])) {
                    $model->attributes = $_POST['RegistrationForm'];
                    if ($model->validate()) {
                        if (!empty($model->password) && $model->password == $model->verifyPassword) {
                            $model->activkey = sha1(microtime() . $model->password);
                            $model->password = Yii::app()->hasher->hashPassword($model->password);
                            $model->verifyPassword = $model->password;

                            if ($model->save()) {
                                $spot = Spot::model()->findByAttributes(array(
                                    'code' => $model->activ_code,
                                    'status' => Spot::STATUS_ACTIVATED,
                                ));

                                $spot->user_id = $model->id;
                                $spot->status = Spot::STATUS_REGISTERED;
                                $spot->save();

                                MMail::activation($model->email, $model->activkey);
                                echo true;
                            }
                            unset(Yii::app()->session['registration_error_count']);
                        }
                    }
                    else {
                        Yii::app()->session['registration_error_count'] = $registration_error_count + 1;
                        echo json_encode(array('error' => $model->getErrors()));
                    }
                }
            }
        }
    }

}