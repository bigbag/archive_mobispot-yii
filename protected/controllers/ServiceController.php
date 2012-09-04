<?php

class ServiceController extends MController
{
    public $defaultAction = 'registration';

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

    public function actionSocial()
    {

        $service = Yii::app()->request->getQuery('service');
        if (isset($service)) {

            $authIdentity = Yii::app()->eauth->getIdentity($service);

            $authIdentity->cancelUrl = $this->createAbsoluteUrl('site/index');

            if ($authIdentity->authenticate()) {
                $identity = new EAuthUserIdentity($authIdentity);

                if ($identity->authenticate()) {

                    $social_id = $identity->getId();
                    if (!User::socialCheck($service, $social_id)) {
                        $this->setCookies('service_name', $service);
                        $this->setCookies('service_id', $social_id);
                        $authIdentity->redirectUrl = '/service/social';
                    } else {
                        $find = User::model()->findByAttributes(array($service . '_id' => $social_id, 'status' => User::STATUS_ACTIVE));
                        $identity = new SUserIdentity($find->email, $find->password);
                        $identity->authenticate();

                        if (isset(Yii::app()->session['referer']) and !empty(Yii::app()->session['referer'])) {
                            $authIdentity->redirect(Yii::app()->session['referer']);
                            unset(Yii::app()->session['referer']);
                        } else $authIdentity->redirect();
                    }
                    $authIdentity->redirect();

                } else {
                    $authIdentity->cancel();
                }
            }
            $this->redirect(array($authIdentity->cancelUrl));
        } else {
            $model = new RegistrationSocialForm;
            if (Yii::app()->request->cookies['service_name'] and Yii::app()->request->cookies['service_id']) {
                if (isset($_POST['RegistrationSocialForm'])) {
                    $model->attributes = $_POST['RegistrationSocialForm'];

                    if ($model->validate()) {
                        $password = md5(time());
                        $model->activkey = sha1(microtime() . $password);
                        $model->password = Yii::app()->hasher->hashPassword($password);
                        $model->lastvisit = time();

                        $model->type = User::TYPE_USER;
                        $model->status = User::STATUS_NOACTIVE;

                        $service = Yii::app()->request->cookies['service_name']->value . '_id';
                        $model->{$service} = Yii::app()->request->cookies['service_id']->value;
                        unset(Yii::app()->request->cookies['service_name']);
                        unset(Yii::app()->request->cookies['service_id']);

                        if ($model->save()) {
                            MMail::activation($model->email, $model->activkey);

                            if (Yii::app()->request->cookies['social_referer']) {
                                $this->redirect(Yii::app()->request->cookies['social_referer']);
                            } else {
                                $this->redirect('/');
                            }
                        }
                    }
                }
                $this->render('social', array('model' => $model));

            } else {
                if (isset(Yii::app()->session['referer']) and !empty(Yii::app()->session['referer'])) {
                    $this->redirect(Yii::app()->session['referer']);
                    unset(Yii::app()->session['referer']);
                } else $this->redirect('/');
            }

        }
    }

    public function setCookies($name, $value)
    {
        $cookie = new CHttpCookie($name, $value);
        $cookie->expire = time() + 60 * 60;
        Yii::app()->request->cookies[$name] = $cookie;
    }

}