<?php

class SpotHardTypeController extends Controller {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout='//layouts/admin_column2';

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionUpload() {
    if (!empty($_FILES)) {
      $maxSize=Yii::app()->par->load('ImageSize');
      $action=$_POST['action'];

      $tempFile=$_FILES['Filedata']['tmp_name'];

      $fileParts=pathinfo($_FILES['Filedata']['name']);

      $fileName=$action.'_'.md5(time().$fileParts['basename']);
      $targetFileName=$fileName.'.jpg';

      if (filesize($tempFile) < $maxSize * 1024) {
        $targetPath=Yii::getPathOfAlias('webroot.uploads.images.').'/';

        $image=new CImageHandler();
        $image->load($tempFile);
        if ($image->thumb(95, 95, true)) {
          $image->save($targetPath.'tmb_'.$fileName.'.jpg');

          $image->reload();
          $image->thumb(300, 300, true);
          $image->save($targetPath.$fileName.'.jpg');
          echo $targetFileName;
        }
        else
          echo "Not a picture file";
      }
      else
        echo "Max size=".$maxSize * 1024;
    }
  }

  public function actionCreate() {
    $model=new SpotHardType;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['SpotHardType'])) {
      $model->attributes=$_POST['SpotHardType'];
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

    if (isset($_POST['SpotHardType'])) {
      $model->attributes=$_POST['SpotHardType'];
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
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/admin/spotHardType/'));
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    $model=new SpotHardType('search');
    $model->unsetAttributes(); // clear any default values
    if (isset($_GET['SpotHardType']))
      $model->attributes=$_GET['SpotHardType'];

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
    $model=SpotHardType::model()->findByPk($id);
    if ($model===null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax']==='spot-hard-type-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

}
