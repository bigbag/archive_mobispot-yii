<?php

/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePassword extends CFormModel
{

    public $password;
    public $verifyPassword;

    public function rules()
    {
        return array(
            array('password, verifyPassword', 'required'),
            array('password', 'length', 'max' => 128, 'min' => 5, 'message' => Yii::t('user', "Incorrect password (minimal length 5 symbols).")),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user', "Retype Password is incorrect.")),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'password' => Yii::t('user', "password"),
            'verifyPassword' => Yii::t('user', "Retype Password"),
        );
    }

}
