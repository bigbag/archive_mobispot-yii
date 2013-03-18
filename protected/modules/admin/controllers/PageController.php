<?php

class PageController extends Controller {

  public $layout='//layouts/admin_column2';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id) {
    $this->render('view', array(
        'model'=>$this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    $model=new Page;

    $this->performAjaxValidation($model);

    if (isset($_POST['Page'])) {
      $model->attributes=$_POST['Page'];
      $model->user_id=Yii::app()->user->id;

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
    $this->performAjaxValidation($model);

    if (isset($_POST['Page'])) {
      $model->attributes=$_POST['Page'];

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
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex() {
    $model=new Page('search');
    $model->unsetAttributes(); // clear any default values
    if (isset($_GET['Page']))
      $model->attributes=$_GET['Page'];

    $this->render('index', array(
        'model'=>$model,
    ));
  }

  public function actionImage() {
    if (!empty($_FILES)) {
      $maxSize=Yii::app()->par->load('pageImageSize');

      $dir=Yii::getPathOfAlias('webroot.uploads.page').'/';

      $file=md5(date('YmdHis')).'.jpg';
      $fileSize=filesize($_FILES['file']['tmp_name']);

      if ($fileSize < $maxSize * 1024) {
        move_uploaded_file($_FILES['file']['tmp_name'], $dir.$file);

        $array=array(
            'filelink'=>$this->createUrl('/uploads/page/'.$file)
        );
        echo stripslashes(json_encode($array));
      }
      else
        echo "Размер файла больше допустимого=".$maxSize * 1024;
    }
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id) {
    $model=Page::model()->findByPk($id);
    if ($model===null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax']==='page-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

}
