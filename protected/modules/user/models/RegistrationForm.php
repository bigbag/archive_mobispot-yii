<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 */
class RegistrationForm extends User
{
    public $verifyPassword;
    public $verifyEmail;
    public $verifyCode;

    public function rules()
    {
        $rules = array(
            array('email, verifyEmail, password', 'required'),
            array('password', 'length', 'max' => 128, 'min' => 5, 'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
            array('email, verifyEmail', 'email'),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => UserModule::t("Retype Password is incorrect.")),
            array('verifyEmail', 'compare', 'compareAttribute' => 'email', 'message' => UserModule::t("Retype Email is incorrect.")),
            array('verifyCode', 'captcha'),
            array('city_id', 'numerical', 'integerOnly' => true),
        );
        return $rules;
    }

    public function behaviors()
    {
        return array(
            'OnAfterRegistrationBehavior' => array(
                'class' => 'application.modules.user.components.OnAfterRegistrationBehavior'
            )
        );
    }

}