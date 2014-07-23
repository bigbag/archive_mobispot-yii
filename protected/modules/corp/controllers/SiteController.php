<?php

class SiteController extends MController
{
    public $layout = '//corp/layouts/all';

    public function actionIndex()
    {
        $this->render('index');
    }

    //Авторизация
    public function actionLogin()
    {
        $data = MHttp::validateRequest();
        $answer = array(
            'error' => "yes",
            "content" => Yii::t('user', "Check your email and password")
        );

        if (!isset($data['email']) or !isset($data['password']))
            MHttp::setBadRequest();

        $form = new LoginForm;
        $data['terms'] = 1;
        $form->attributes = $data;
        if (!$form->validate())
            MHttp::getJsonAndExit($answer);

        User::autoLogin($form);
        $answer['error'] = "no";

        echo json_encode($answer);
    }

    public function actionLogout()
    {
        if (!Yii::app()->request->isPostRequest) {
            Spot::clearCurrentSpotView();
            Spot::clearCurrentSpot();
            Yii::app()->user->logout();
            $this->redirect("/corp");
        }

        if (!(Yii::app()->user->isGuest)) {
            Spot::clearCurrentSpot();
            Spot::clearCurrentSpotView();
            Yii::app()->user->logout();
            unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
        }
    }

}
