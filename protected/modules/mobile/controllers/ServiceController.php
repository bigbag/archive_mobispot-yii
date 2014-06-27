<?php

class ServiceController extends MController
{
    //Выход
    public function actionLogout()
    {
        if (!Yii::app()->request->isPostRequest) {
            Yii::app()->user->logout();
            $this->redirect("/");
        }

        if (!(Yii::app()->user->isGuest)) {
            Yii::app()->cache->get('user_' . Yii::app()->user->id);
            Yii::app()->user->logout();
            unset(Yii::app()->request->cookies['YII_CSRF_TOKEN']);
        }
    }
}