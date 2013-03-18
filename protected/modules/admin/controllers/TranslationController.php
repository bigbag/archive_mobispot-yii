<?php

class TranslationController extends Controller {

  public $layout='//layouts/admin_column1';

  public function actionIndex() {
    $model=new ContentTranslation('search');
    $model->unsetAttributes(); // clear any default values
    if (isset($_GET['ContentTranslation']))
      $model->attributes=$_GET['ContentTranslation'];

    $this->render('index', array(
        'model'=>$model,
    ));
  }

  public function actionUpdate($id) {
    $model=$this->loadModel($id);
    $path_en=Yii::getPathOfAlias('application.messages').'/en/'.$model->name.'.php';
    $path_ru=Yii::getPathOfAlias('application.messages').'/ru/'.$model->name.'.php';
    $content_en=require($path_en);
    $content_ru=require($path_ru);

    if ((isset($_POST['Translation_ru'])) and (isset($_POST['Translation_en']))) {

      $array_ru=str_replace("\r", '', var_export($_POST['Translation_ru'], true));
      $array_en=str_replace("\r", '', var_export($_POST['Translation_en'], true));

      $content_ru=<<<EOD
<?php
return $array_ru;

EOD;
      $content_en=<<<EOD
<?php
return $array_en;

EOD;

      file_put_contents($path_en, $content_en);
      file_put_contents($path_ru, $content_ru);
      $this->redirect('/admin/translation/');
    }

    $this->render('update', array(
        'model'=>$model,
        'content_en'=>$content_en,
        'content_ru'=>$content_ru,
    ));
  }

  public function loadModel($id) {
    $model=ContentTranslation::model()->findByPk($id);
    if ($model===null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax']==='translation-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

}