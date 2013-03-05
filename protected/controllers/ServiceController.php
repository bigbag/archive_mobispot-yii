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
  
  public function actionLang()
  {
    $lang = Yii::app()->request->getQuery('id');
    if (isset($lang[0])) {
      $all_lang = Lang::getLangArray();
      if (isset($all_lang[$lang])) {
        
        Yii::app()->session['lang'] = 'value';
        Yii::app()->request->cookies['lang'] = new CHttpCookie('lang', $lang);
        
        if (isset(Yii::app()->user->id)) {
          $user = User::model()->findByPk(Yii::app()->user->id);
          if (isset($user)) {
            $user->lang = $lang;
            $user->save();
          }
        }
      }
    }
    $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
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
    $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
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
  
  public function actionActivation()
  {
    if (Yii::app()->user->id) {
      $this->redirect('/');
      } else {
      $email = $_GET['email'];
      $activkey = $_GET['activkey'];
      
      if ($email && $activkey) {
        $find = User::model()->findByAttributes(array('email' => $email));
        if (isset($find->activkey) && ($find->activkey == $activkey)) {
          $find->activkey = sha1(microtime());
          $find->status = User::STATUS_ACTIVE;
          if ($find->save()) {
            
            $identity = new SUserIdentity($find->email, $find->password);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);
            $this->redirect('/');
          }
          } else $this->render('activation',
          array(
            'title' => Yii::t('user', "Активация пользователя"),
            'content' => Yii::t('user', "Неверная активационная ссылка.")
        ));
        } else $this->render('activation',
        array(
          'title' => Yii::t('user', "Активация пользователя"),
          'content' => Yii::t('user', "Неверная активационная ссылка.")
      ));
    }
  }
  
  public function actionRecovery()
  {
    if (Yii::app()->user->id) {
      $this->redirect('/');
      } else {
      $email = ((isset($_GET['email'])) ? $_GET['email'] : '');
      $activkey = ((isset($_GET['activkey'])) ? $_GET['activkey'] : '');
      if ($email && $activkey) {
        $form = new UserChangePassword;
        $find = User::model()->findByAttributes(array('email' => $email));
        if (isset($find) && $find->activkey == $activkey) {
          if (isset($_POST['UserChangePassword'])) {
            $form->attributes = $_POST['UserChangePassword'];
            $soucePassword = $form->password;
            
            if ($form->validate()) {
              $find->password = Yii::app()->hasher->hashPassword($form->password);
              $find->activkey = sha1(microtime() . $form->password);
              $find->save();
              
              $identity = new UserIdentity($email, $soucePassword);
              $identity->authenticate();
              $this->lastVisit();
              $this->redirect('/');
            }
          }
          $this->render('changepassword', array('form' => $form));
        } else  $this->redirect('/');
      } else $this->redirect('/');
    }
  }
  
  public function actionSocial()
  {
    $service = Yii::app()->request->getQuery('service');
    if (isset($service)) {
      
      $authIdentity = Yii::app()->eauth->getIdentity($service);
      
      $authIdentity->cancelUrl = '/site/index';
      
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
            $find = User::model()->findByAttributes(array($service . '_id' => $social_id));
            $identity = new SUserIdentity($find->email, $find->password);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);
            
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
        
        $email = '';
        if (!empty(Yii::app()->request->cookies['service_email']->value)) {
          $email = Yii::app()->request->cookies['service_email']->value;
        }
        if (isset($_POST['RegistrationSocialForm'])) {
          $model->attributes = $_POST['RegistrationSocialForm'];
          
          if ($model->validate()) {
            $password = md5(time());
            $model->activkey = sha1(microtime() . $password);
            $model->password = Yii::app()->hasher->hashPassword($password);
            
            
            $model->type = User::TYPE_USER;
            $model->status = User::STATUS_NOACTIVE;
            
            $service = Yii::app()->request->cookies['service_name']->value . '_id';
            $model->{$service} = Yii::app()->request->cookies['service_id']->value;
            unset(Yii::app()->request->cookies['service_name']);
            unset(Yii::app()->request->cookies['service_id']);
            
            if ($model->save()) {
              $spot = Spot::model()->findByAttributes(array(
                  'code' => $model->activ_code,
                  'status' => Spot::STATUS_ACTIVATED,
              ));
              
              $spot->user_id = $model->id;
              $spot->status = Spot::STATUS_REGISTERED;
              $spot->save();
              
              MMail::activation($model->email, $model->activkey, (Yii::app()->request->cookies['lang']) ? Yii::app()->request->cookies['lang']->value : 'en');
              
              if (Yii::app()->request->cookies['social_referer']) {
                $this->redirect(Yii::app()->request->cookies['social_referer']);
                } else {
                $this->redirect('/');
              }
            }
          }
        }
        $this->render('social',
          array(
            'model' => $model,
            'service' => Yii::app()->request->cookies['service_name'],
            'email' => $email,
        ));
        
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