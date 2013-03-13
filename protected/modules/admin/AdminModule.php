<?php

class AdminModule extends CWebModule {

  public function init() {
    // this method is called when the module is being created
    // you may place code here to customize the module or the application
    // import the module-level models and components
    $this->setImport(array(
        'admin.models.*',
        'admin.components.*',
        'application.extensions.imperavi-redactor-widget.*',
    ));
  }

  public function beforeControllerAction($controller, $action) {
    if (parent::beforeControllerAction($controller, $action)) {
      $user = false;

      if (isset(Yii::app()->user->id))
        $user = User::model()->findByPk(Yii::app()->user->id);

      if (!$user or ($user and $user->type != User::TYPE_ADMIN)) {
        throw new CHttpException(403, Yii::t('user', 'You are not allowed to perform this action.'));
      }

      return true;
    }
    else
      return false;
  }

}
