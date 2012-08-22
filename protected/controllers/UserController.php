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
            $model = new LoginCaptchaForm;
            if (isset($_POST['LoginCaptchaForm'])) {
                $model->attributes = $_POST['LoginCaptchaForm'];
                if ($model->rememberMe == 'on') $model->rememberMe = 1;
                else $model->rememberMe = 0;
                if ($model->validate()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $this->render('login', array('model' => $model));
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
            $this->render('registration', array('model' => $model));
        }
    }

    public function actionActivation(){
        if (Yii::app()->user->id) {
            $this->redirect('/');
        }
        else{
            $email = $_GET['email'];
            $activkey = $_GET['activkey'];

            if ($email && $activkey) {
                $find = User::model()->findByAttributes(array('email' => $email));
                if (isset($find->activkey) && ($find->activkey == $activkey)) {
                    $find->activkey = sha1(microtime());
                    $find->status = User::STATUS_ACTIVE;
                    if ($find->save()){
                        $this->render('activation',
                            array(
                                'title' => Yii::t('user', "Активация пользователя"),
                                'content' => Yii::t('user', "Вы успешно активировали учётную запись.")
                            ));
                    }
                }
                else $this->render('activation',
                    array(
                        'title' => Yii::t('user', "Активация пользователя"),
                        'content' => Yii::t('user', "Неверная активационная ссылка.")
                    ));
            }
            else $this->render('activation',
                array(
                    'title' => Yii::t('user', "Активация пользователя"),
                    'content' => Yii::t('user', "Неверная активационная ссылка.")
                ));
        }
    }

    public function actionProfile(){
        if (!Yii::app()->user->id) {
            $this->setAccess();
        }
        else{
            $user = User::model()->findByPk(Yii::app()->user->id);
            $profile = UserProfile::model()->findByPk(Yii::app()->user->id);

            if (isset($_POST['UserProfile'])) {
                if (isset($_POST['password']) and Yii::app()->hasher->checkPassword($_POST['password'], $user->password)){
                    $profile->attributes = $_POST['UserProfile'];
                    if ($profile->validate()) {
                        $profile->save();
                        $this->refresh();
                    }
                }
                else{
                    Yii::app()->user->setFlash('profile', Yii::t('profile', "Для изменения профиля вы должны вести свой пароль."));
                }
            }
            $this->render('profile', array(
                'profile' => $profile,
            ));
        }
    }

    public function actionAccount(){
        if (!Yii::app()->user->id) {
            $this->setAccess();
        }
        else{
            $this->render('account');
        }

    }
}