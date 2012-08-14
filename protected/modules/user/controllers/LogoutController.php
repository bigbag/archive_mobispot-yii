<?php

class LogoutController extends Controller
{
    public $defaultAction = 'logout';

    public $layout = '//layouts/admin_column1';

    /**
     * Logout the current user and redirect to returnLogoutUrl.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->controller->module->returnLogoutUrl);
    }

}