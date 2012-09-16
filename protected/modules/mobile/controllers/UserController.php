<?php

class UserController extends MController
{
    public $layout = '//layouts/mobile';

    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) {
            $form = new LoginForm;
            if (isset($_POST['LoginForm'])) {
                $form->attributes = $_POST['LoginForm'];
                $form->rememberMe = true;
                if ($form->validate()) {
                    $identity = new UserIdentity($form->email, $form->password);
                    if ($identity->authenticate()) {
                        Yii::app()->user->login($identity);
                        $this->lastVisit();
                        $this->redirect('/user/account');
                    }
                }
            }
            $this->render('index',
                array('form' => $form)
            );
        } else
            $this->redirect('/user/account');
    }

    public function actionAccount()
    {
        $this->render('account',
            array()
        );

    }
}