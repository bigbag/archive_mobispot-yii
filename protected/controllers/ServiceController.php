<?php

class ServiceController extends MController {

  public $defaultAction='registration';

  public function actions() {
    return array(
        'captcha'=>array(
            'class'=>'application.extensions.kcaptcha.KCaptchaAction',
            'maxLength'=>6,
            'minLength'=>5,
            'foreColor'=>array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100)),
            #'backColor'=>array(mt_rand(200, 210), mt_rand(210, 220), mt_rand(220, 230))
        ),
    );
  }

  //Смена языка
  public function actionLang($id) {
    $lang=$id;
    $all_lang=Lang::getLangArray();
    if (isset($all_lang[$lang])) {

      Yii::app()->session['lang']='value';
      Yii::app()->request->cookies['lang']=new CHttpCookie('lang', $lang);

      if (isset(Yii::app()->user->id)) {
        $user=User::model()->findByPk(Yii::app()->user->id);
        if (isset($user)) {
          $user->lang=$lang;
          $user->save(false);
        }
      }
    }
    $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
  }

  //Авторизация
  public function actionLogin() {
    if (Yii::app()->request->isPostRequest) {
      $error="yes";
      $data=$this->getJson();

      if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
        if (isset($data['email']) and isset($data['password'])) {

          $form=new LoginForm;

          $form->attributes=$data;
          if ($form->validate()) {
            $identity=new UserIdentity($form->email, $form->password);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);
            $error="no";
          }
        }
      }
      echo json_encode(array('error'=>$error));
    }
  }

  //Выход
  public function actionLogout() {
    if (Yii::app()->request->isPostRequest) {
      if (!(Yii::app()->user->isGuest)) {
        Yii::app()->cache->get('user_'.Yii::app()->user->id);
        Yii::app()->user->logout();
        unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
        echo true;
      }
      echo false;
    }
    else {
      Yii::app()->user->logout();
      $this->redirect(Yii::app()->homeUrl);
    }
  }

  //Регистрация
  public function actionRegistration() {
    if (Yii::app()->request->isPostRequest) {
      $error="yes";
      $content="";
      $data=$this->getJson();

      if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken and (empty($data['name']))) {
        if (isset($data['email']) and isset($data['password'])) {
          $model=new RegistrationForm;
          $model->attributes=$data;

          if (Yii::app()->request->cookies['service_name'] and Yii::app()->request->cookies['service_id']) {
            $service_name=Yii::app()->request->cookies['service_name']->value;
            $service_name=$service_name.'_id';
            $model->{$service_name}=Yii::app()->request->cookies['service_id']->value;
          }

          if ($model->validate()) {
            if (!empty($model->password)) {
              $model->activkey=sha1(microtime().$model->password);
              $model->password=Yii::app()->hasher->hashPassword($model->password);

              if ($model->save()) {
                $spot=Spot::model()->findByAttributes(array(
                    'code'=>$model->activ_code,
                    'status'=>Spot::STATUS_ACTIVATED,
                ));

                $spot->user_id=$model->id;
                $spot->lang=$this->getLang();
                $spot->status=Spot::STATUS_REGISTERED;
                $spot->save();

                MMail::activation($model->email, $model->activkey, $this->getLang());
                $content=Yii::t('user', "To your specified email, it was sent to you with instructions on how to activate your account.");
                $error="no";
              }
            }
          }
        }
      }
      echo json_encode(array('error'=>$error, 'content'=>$content));
    }
  }

//Активация учетки
  public function actionActivation() {
    if (Yii::app()->user->id) {
      $this->redirect('/');
    } else {
      $email=$_GET['email'];
      $activkey=$_GET['activkey'];

      if ($email && $activkey) {
        $find=User::model()->findByAttributes(array('email'=>$email));
        if (isset($find->activkey) && ($find->activkey==$activkey)) {
          $find->activkey=sha1(microtime());
          $find->status=User::STATUS_ACTIVE;
          if ($find->save()) {

            $identity=new SUserIdentity($find->email, $find->password);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);
            $this->redirect('/');
          }
        }
        else
          $this->render('activation', array(
              'title'=>Yii::t('user', "Активация пользователя"),
              'content'=>Yii::t('user', "Неверная активационная ссылка.")
          ));
      }
      else
        $this->render('activation', array(
            'title'=>Yii::t('user', "Активация пользователя"),
            'content'=>Yii::t('user', "Неверная активационная ссылка.")
        ));
    }
  }

  //Восстановление пароля
  public function actionRecovery() {
    if (Yii::app()->request->isPostRequest) {
      $error="yes";
      $content="";
      $data=$this->getJson();

      if (isset($data['token']) and $data['token']==Yii::app()->request->csrfToken) {
        if(isset($data['action']) and $data['action']=="recovery") {
          $form=new RecoveryForm;
          if (isset($data['email'])) {
            $form->email=$data['email'];
            if ($form->validate()) {
              $user=User::model()->findByAttributes(
                array(
                  'email'=>$form->email,
                  'status'=>User::STATUS_VALID,
                  )
                );
              if ($user) {
                MMail::recovery($user->email, $user->activkey, $this->getLang());
                $content=Yii::t('user', "To your specified email, it was sent to you with instructions to reset your password.");
                $error="no";
              }
            }
          }
        }
        else if (isset($data['action']) and $data['action']=="change") {
          if (isset($data['activkey']) and isset($data['email'])){
            if (isset($data['password']) and isset($data['confirmPassword'])){
              if ($data['password']==$data['confirmPassword']){
                $user=User::model()->findByAttributes(array('email'=>$data['email'], 'activkey'=>$data['activkey']));
                if ($user) {
                  $user->password=Yii::app()->hasher->hashPassword($data['password']);
                  $user->activkey=sha1(microtime().$data['password']);
                  $user->save(false);

                  $identity=new UserIdentity($data['email'], $data['password']);
                  $identity->authenticate();
                  $this->lastVisit();
                  Yii::app()->user->login($identity);

                  $error="no";
                }
              }
            }
          }
        }
      }
      echo json_encode(array('error'=>$error, 'content'=>$content));
    }
    else {
      $email=((isset($_GET['email'])) ? $_GET['email'] : '');
      $activkey=((isset($_GET['activkey'])) ? $_GET['activkey'] : '');
      if ($email && $activkey) {

        $find=User::model()->findByAttributes(array('email'=>$email));
        if (isset($find) && $find->activkey==$activkey) {
          $this->render(
            'changepassword',
            array(
              'email'=>$email,
              'activkey'=>$activkey,
            ));
        }
        else {
          $this->redirect('/');
        }
      }
      else {
          $this->redirect('/');
      }
    }
  }

  //регистрация через соц сети
  public function actionSocial() {
    $service=Yii::app()->request->getQuery('service');
    if (isset($service)) {

      $authIdentity=Yii::app()->eauth->getIdentity($service);

      $authIdentity->cancelUrl='/site/index';

      if ($authIdentity->authenticate()) {
        $identity=new CEAuthUserIdentity($authIdentity);

        if ($identity->authenticate()) {

          $social_id=$identity->getId();
          $service_email=$identity->getState('email', '');

          if (!User::socialCheck($service, $social_id)) {
            $this->setCookies('service_name', $service);
            $this->setCookies('service_id', $social_id);
            $this->setCookies('service_email', $service_email);
            $authIdentity->redirectUrl='/service/social';
          } else {
            $find=User::model()->findByAttributes(array($service.'_id'=>$social_id));
            $identity=new SUserIdentity($find->email, $find->password);
            $identity->authenticate();
            $this->lastVisit();
            Yii::app()->user->login($identity);

            if (isset(Yii::app()->session['referer']) and !empty(Yii::app()->session['referer'])) {
              $authIdentity->redirect(Yii::app()->session['referer']);
              unset(Yii::app()->session['referer']);
            }
            else
              $authIdentity->redirect();
          }
          $authIdentity->redirect();
        } else {
          $authIdentity->cancel();
        }
      }
      $this->redirect(array($authIdentity->cancelUrl));
    } else {
      $model=new RegistrationSocialForm;
      if (Yii::app()->request->cookies['service_name'] and Yii::app()->request->cookies['service_id']) {

        $email='';
        if (!empty(Yii::app()->request->cookies['service_email']->value)) {
          $email=Yii::app()->request->cookies['service_email']->value;
        }
        if (isset($_POST['RegistrationSocialForm'])) {
          $model->attributes=$_POST['RegistrationSocialForm'];

          if ($model->validate()) {
            $password=md5(time());
            $model->activkey=sha1(microtime().$password);
            $model->password=Yii::app()->hasher->hashPassword($password);


            $model->type=User::TYPE_USER;
            $model->status=User::STATUS_NOACTIVE;

            $service=Yii::app()->request->cookies['service_name']->value.'_id';
            $model->{$service}=Yii::app()->request->cookies['service_id']->value;
            unset(Yii::app()->request->cookies['service_name']);
            unset(Yii::app()->request->cookies['service_id']);

            if ($model->save()) {
              $spot=Spot::model()->findByAttributes(array(
                  'code'=>$model->activ_code,
                  'status'=>Spot::STATUS_ACTIVATED,
              ));

              $spot->user_id=$model->id;
              $spot->status=Spot::STATUS_REGISTERED;
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
        $this->render('social', array(
            'model'=>$model,
            'service'=>Yii::app()->request->cookies['service_name'],
            'email'=>$email,
        ));
      } else {
        if (isset(Yii::app()->session['referer']) and !empty(Yii::app()->session['referer'])) {
          $this->redirect(Yii::app()->session['referer']);
          unset(Yii::app()->session['referer']);
        }
        else
          $this->redirect('/');
      }
    }
  }

  public function setCookies($name, $value) {
    $cookie=new CHttpCookie($name, $value);
    $cookie->expire=time() + 60 * 60;
    Yii::app()->request->cookies[$name]=$cookie;
  }

}