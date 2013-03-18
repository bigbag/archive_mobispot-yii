<?php

class ServiceController extends MController {

  public $layout='//layouts/mobile';

  public function actionLang() {
    $lang=Yii::app()->request->getQuery('id');
    if (isset($lang[0])) {
      $all_lang=Lang::getLangArray();
      if (isset($all_lang[$lang])) {
        Yii::app()->request->cookies['lang']=new CHttpCookie('lang', $lang);

        if (isset(Yii::app()->user->id)) {
          $user=User::model()->findByPk(Yii::app()->user->id);
          if (isset($user)) {
            $user->lang=$lang;
            $user->save();
          }
        }
      }
    }
    $this->redirect((isset($_SERVER["HTTP_REFERER"])) ? $_SERVER["HTTP_REFERER"] : '/');
  }

  public function actionRecovery() {
    $form=new RecoveryForm;
    if (isset($_POST['RecoveryForm'])) {
      $form->email=$_POST['RecoveryForm']['email'];
      if ($form->validate()) {
        $user=User::model()->findByAttributes(array('email'=>$form->email));
        MMail::recovery($user->email, $user->activkey, (Yii::app()->request->cookies['lang']) ? Yii::app()->request->cookies['lang']->value : 'en');
        Yii::app()->user->setFlash('success', Yii::t('mobile', 'По указанному вами адресу отправлено письмо<br/> с информацией о востановлении пароля.'));
      }
    }
    $this->render('recovery', array('form'=>$form)
    );
  }

}