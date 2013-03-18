<?php

class QuestionForm extends CFormModel {

  public $email;
  public $name;
  public $question;

  public function rules() {
    return array(
        // email and password are required
        array('email, name, question', 'required'),
        array('email', 'email'),
        array('email, name, question', 'filter', 'filter'=>'trim'),
        array('name, question', 'filter', 'filter'=>array($obj=new CHtmlPurifier(), 'purify')),
    );
  }

}
