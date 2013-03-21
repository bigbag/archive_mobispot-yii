<?php

class PagesController extends MController {

  public function actionIndex() {
    $slug=Yii::app()->request->getQuery('id');

    $model=Page::findBySlug($slug);
    if ($model=null)
      throw new CHttpException(404, 'The requested page does not exist.');

    $this->render('index', array(
        'model'=>$model,
    ));
  }

  public function actionHelp() {
    $this->render('sections/'.Yii::app()->language.'/help');
  }

  public function actionSections($id) {
    $this->layout='//layouts/slider';
    $this->render('sections/'.Yii::app()->language.'/'.$id);
  }

}