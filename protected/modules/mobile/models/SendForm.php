<?php

class SendForm extends CFormModel
{

    public $email;
    public $terms;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            array('email', 'required'),
            array('email', 'email'),
            array('terms', 'required'),
            array('terms', 'in', 'range' => array(1)),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('user', "Email"),
        );
    }

}
