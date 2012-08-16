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
    public $terms;
    public $discodes_code;

    public function rules()
    {
        $rules = array(
            array('email, verifyEmail, password', 'required'),
            array('password', 'length', 'max' => 128, 'min' => 5, 'message' => Yii::t('user', "Incorrect password (minimal length 5 symbols).")),
            array('terms', 'in', 'range' => array(1), 'message' => Yii::t('user', "To register, you must agree to the terms of this agreement")),
            array('email, verifyEmail', 'email'),
            array('email', 'unique', 'message' => Yii::t('user', "This user's email address already exists.")),
            array('verifyPassword', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('user', "Retype Password is incorrect.")),
            array('verifyEmail', 'compare', 'compareAttribute' => 'email', 'message' => Yii::t('user', "Retype Email is incorrect.")),
            array('verifyCode', 'captcha'),
            array('discodes_code', 'checkexists'),
        );
        return $rules;
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->discodes_code) {
                $discodes = Discodes::model()->findByAttributes(array('code' => $this->discodes_code, 'status' => Discodes::STATUS_INIT));
            } else $discodes = null;

            if ($discodes === null)
                if ($this->discodes_code) {
                    $this->addError("discodes_code", Yii::t('user', "The activation code is incorrect spot."));
                }
        }
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