<?php

class ContentBannerFooterController extends Controller {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout='//layouts/admin_column2';

  public function actionUpload() {
    if (!empty($_FILES)) {
      $action=$_POST['action'];

      $tempFile=$_FILES['Filedata']['tmp_name'];
      $targetPath=Yii::getPathOfAlias('webroot.uploads.blocks.').'/';
      $targetFileName=$action.'_'.time().'_'.$_FILES['Filedata']['name'];
      $targetFile=rtrim($targetPath, '/').'/'.$targetFileName;

      move_uploaded_file($tempFile, $targetFile);

      echo $targetFileName;
    }
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    $model=new ContentBannerFooter;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['ContentBannerFooter'])) {
      $model->attributes=$_POST['ContentBannerFooter'];
      if ($model->save())
        $this->redirect(array('index'));
    }

    $this->render('create', array(
        'model'=>$model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id) {
    $model=$this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['ContentBannerFooter'])) {
      $model->attributes=$_POST['ContentBannerFooter'];
      if ($model->save())
        $this->redirect(array('index'));
    }

    $this->render('update', array(
        'model'=>$model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id) {
    $this->loadModel($id)->delete();

    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    $model=new ContentBannerFooter('search');
    $model->unsetAttributes(); // clear any default values
    if (isset($_GET['ContentBannerFooter']))
      $model->attributes=$_GET['ContentBannerFooter'];

    $this->render('index', array(
        'model'=>$model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id) {
    $model=ContentBannerFooter::model()->findByPk($id);
    if ($model===null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax']==='content-banner-footer-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

}
