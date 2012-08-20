<?php

class UserController extends MController
{

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
        if (Yii::app()->user->isGuest) {
            $model = new LoginForm;
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                if ($model->validate()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $this->render('/user/login', array('model' => $model));
        } else
            $this->redirect(Yii::app()->user->returnUrl);
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionRegistration()
    {
        $model = new RegistrationForm;

        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (Yii::app()->user->id) {
            $this->redirect(Yii::app()->user->returnUrl);
        } else {
            if (isset($_POST['RegistrationForm'])) {
                $model->attributes = $_POST['RegistrationForm'];
                if ($model->validate()) {
                    if (!empty($model->password) && $model->password == $model->verifyPassword) {
                        $model->activkey = sha1(microtime() . $model->password);
                        $model->password = Yii::app()->hasher->hashPassword($model->password);
                        $model->verifyPassword = $model->password;
                    }
                    if ($model->save()) {

                        $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                        //UserModule::sendMail($model->email, Yii::t('user', "You registered from {site_name}", array('{site_name}' => Yii::app()->name)), Yii::t('user', "Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                        Yii::app()->user->setFlash('registration', Yii::t('user', "Thank you for your registration. Please check your email."));
                        $this->refresh();
                    }
                }
            }
            $this->render('/user/registration', array('model' => $model));
        }
    }
}