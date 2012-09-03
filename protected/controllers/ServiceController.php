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
                
                $identity = new CEAuthUserIdentity($authIdentity);
                
                if ($identity->authenticate()) {
                    
                    $social_id = $identity->getId();
                    $service_email = $identity->getState('email', '');
                    
                    if (!User::socialCheck($service, $social_id)) {
                        $this->setCookies('service_name', $service);
                        $this->setCookies('service_id', $social_id);
                        $this->setCookies('service_email', $service_email);
                        $authIdentity->redirectUrl = '/service/social';
                    } else {
                        //$find = User::model()->findByAttributes(array($service . '_id' => $social_id));
                        //$identity = new ServiceUserIdentity($find->email, $find->password);
                        $identity = new ServiceUserIdentity($identity);
                        $res = $identity->authenticate();
                        $duration = 0; // 30 days
                        Yii::app()->user->login($identity, $duration);
                        $this->lastVisit();
                        unset(Yii::app()->session['login_error_count']);
                        
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
            $model = new RegistrationForm();
            
            if (Yii::app()->request->cookies['service_name'] and Yii::app()->request->cookies['service_id']) {
                
                $email = '';
                if(!empty(Yii::app()->request->cookies['service_email']->value)) {
                    $email = Yii::app()->request->cookies['service_email']->value;
                }
                
                /*
                $find = User::model()->findByAttributes(array('email'=>$email));
                if($find) {
                  
                }*/
                
                $this->render('social', array(
                    'model' => $model, 
                    'service_name' => Yii::app()->request->cookies['service_name']->value,
                    'email' => $email,
                    'password' => time()
                    )
                );

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