<?php

class RegisterConnectionForm extends CFormModel
{
  public $name;
  public $person;
  public $email;
  public $count;
  public $parentName;
  public $address;
  public $parentSubdomain;
  public $url;

  /**
  * Declares the validation rules.
  * The rules state that username and password are required,
  * and password needs to be authenticated.
  */
  public function rules()
  {
    return array(
      // email and password are required
      array('name, person, email', 'required'),
      array('email', 'email'),
      array('name, parentName, address, person', 'length', 'max'=>300),
      array('count', 'numerical', 'integerOnly'=>true),
      array('name, email, url, parentName, address, person', 'filter', 'filter' => 'trim'),
      array('url', 'url'),
    );
  }

  /**
  * Declares attribute labels.
  */
  public function attributeLabels()
  {
    return array(
      'name' => "Название компании *",
      'person' => "Контактное лицо *",
      'email' => "Адрес электронной почты *",
      'count' => "Количество сотрудников *",
      'parentName' => "Название компании-владельца оборудования",
      'address' => "Адрес расположения оборудования",
      'url' => "Домен владельца оборудования на mobispot.com",
    );
  }
}