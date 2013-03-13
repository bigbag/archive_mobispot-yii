<?php

class FaqController extends MController {

  public function actionIndex() {
    $model = ContentFaq::getFaq();
    $form = new QuestionForm();

    $this->render('index', array(
        'model' => $model,
        'form' => $form,
    ));
  }

}