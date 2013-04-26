<?php

class RegisterRentForm extends CFormModel
{
  public $name;
  public $person;
  public $email;
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
      array('name, person, email, address', 'required'),
      array('email', 'email'),
      array('name, address, person', 'length', 'max'=>300),
      array('pos, coffe, api', 'numerical', 'integerOnly'=>true),
      array('name, email, url, address, person', 'filter', 'filter' => 'trim'),
      array('url', 'url'),
    );
  }

  public function afterValidate()
  {

    if ($this->api) $this->api='Нужен';
    else $this->api='Не нужен';

    return parent::beforeValidate();
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
      'pos' => "Кассовый терминал",
      'coffe' => "Кофе-машина",
      'address' => "Адрес размещения оборудования",
      'url' => "Веб-сайт компании",
      'api' => "Доступ к api",
    );
  }
}
