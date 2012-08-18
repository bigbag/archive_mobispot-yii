<?php

class AjaxController extends MController
{
    public function filters()
    {
        return array(
            'ajaxOnly',
        );
    }

    function actionLogin()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {

                $form = new UserLogin;
                if (isset($_POST['LoginForm'])) {
                    $form->attributes = $_POST['LoginForm'];
                    $form->rememberMe = true;
                    if ($form->validate()) {
                        $identity = new UserIdentity($form->email, $form->password);
                        $identity->authenticate();
                        $this->lastVisit();
                        $txt = $this->renderPartial("/layouts/block/_menu_auth", array());
                        echo $txt;
                    }
                } else echo false;
            }
        }
    }

    function actionLogout()
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

    function actionRecovery()
    {
        if (Yii::app()->request->isAjaxRequest and isset($_POST['token'])) {
            if ($_POST['token'] == Yii::app()->request->csrfToken) {
                $form = new UserRecoveryForm;
                if (isset($_POST['email'])) {
                    $form->email = $_POST['email'];
                    if ($form->validate()) {
                        $user = User::model()->findByAttributes(array('email' => $form->email));

                        echo true;
                    } else echo false;
                }
            }
        }
    }

}