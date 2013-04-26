<?php

class RegisterSelfForm extends CFormModel
{
  public $name;
  public $person;
  public $email;
  public $count;
  public $pos;
  public $coffe;
  public $address;
  public $url;
  public $api;


  /**
  * Declares the validation rules.
  * The rules state that username and password are required,
  * and password needs to be authenticated.
  */
  public function rules()
  {
    return array(
      // email and password are required
      array('name, person, count, email, address', 'required'),
      array('email', 'email'),
      array('name, address, person', 'length', 'max'=>300),
      array('pos, coffe, count, api', 'numerical', 'integerOnly'=>true),
      array('name, email, url, address, person', 'filter', 'filter' => 'trim'),
      array('url', 'url'),
    );
  }

  /**
  * Declares attribute labels.
  */
  public function attributeLabels()
  {
    return array(
      'name' => "Название компании",
      'person' => "Контактное лицо",
      'email' => "Адрес электронной почты",
      'count' => "Количество сотрудников",
      'pos' => "Количество кассовых терминалов",
      'coffe' => "Количество кофе-машин",
      'address' => "Адрес размещения оборудования",
      'url' => "Веб-сайт компании",
      'api' => "Доступ к api",
    );
  }
}