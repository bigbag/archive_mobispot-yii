<?php

/**
 * UserRecoveryForm class.
 * UserRecoveryForm is the data structure for keeping
 * user recovery form data. It is used by the 'recovery' action of 'UserController'.
 */
class RecoveryForm extends CFormModel
{
    public $email;

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
            array('email', 'filter', 'filter' => 'trim'),
            array('email', 'checkexists'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => Yii::t('user', 'Email'),
        );
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::model()->findByAttributes(array('email' => $this->email));

            if ($user === null)
                $this->addError("email", Yii::t('user', "Email is incorrect."));
        }
    }

}