<?php

class SpotTypeController extends Controller {

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/admin_column2';

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate() {
    $model = new SpotType;

    $fields = false;

    if (isset($_POST['SpotType'])) {
      $model->attributes = $_POST['SpotType'];

      if ($_POST['SpotType']['fields']['name'][0] and $_POST['SpotType']['fields']['field_id'][0]) {
        $fields = array();
        $name = $_POST['SpotType']['fields']['name'];
        $field_id = $_POST['SpotType']['fields']['field_id'];
        $i = 0;
        foreach ($field_id as $row) {
          if (isset($name[$i][1]))
            $fields[$name[$i]] = $row;
          $i++;
        }

        foreach ($fields as $key => $value) {
          $field = new SpotLinkTypeField();
          $field->name = $key;
          $field->field_id = $value;
          $model->fields[] = $field;
        }
        if ($fields) {
          $model->fields_flag = count($fields);
        }
      }

      if ($model->save())
        $this->redirect(array('index'));
    }

    $model->fields = $fields;

    $this->render('create', array(
        'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id) {
    $model = $this->loadModel($id);

    $type_fields = SpotLinkTypeField::getSpotTypeField($id);
    $fields = array();
    foreach ($type_fields as $row) {
      $fields[$row->name] = $row->field_id;
    }

    if (isset($_POST['SpotType'])) {
      $model->attributes = $_POST['SpotType'];

      if ($_POST['SpotType']['fields']['name'][0] and $_POST['SpotType']['fields']['field_id'][0]) {
        $fields = array();
        $name = $_POST['SpotType']['fields']['name'];
        $field_id = $_POST['SpotType']['fields']['field_id'];
        $i = 0;
        foreach ($field_id as $row) {
          if (isset($name[$i][1]))
            $fields[$name[$i]] = $row;
          $i++;
        }

        foreach ($fields as $key => $value) {
          $field = new SpotLinkTypeField();
          $field->name = $key;
          $field->field_id = $value;
          $model->fields[] = $field;
        }
        if ($fields) {
          $model->fields_flag = count($fields);
        }
      }

      if ($model->save()) {
        $this->redirect(array('index'));
      }
    }
    $model->fields = $fields;
    $this->render('update', array(
        'model' => $model,
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
    $model = new SpotType('search');
    $model->unsetAttributes(); // clear any default values
    if (isset($_GET['SpotType']))
      $model->attributes = $_GET['SpotType'];

    $this->render('index', array(
        'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id) {
    $model = SpotType::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model) {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'spot-type-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

}
