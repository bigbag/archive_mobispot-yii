<?php

/**
 * UserRecoveryForm class.
 * UserRecoveryForm is the data structure for keeping
 * user recovery form data. It is used by the 'recovery' action of 'UserController'.
 */
class UserRecoveryForm extends CFormModel
{
    public $email, $user_id;

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
            array('email', 'checkexists'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email' => UserModule::t("email"),
        );
    }

    public function checkexists($attribute, $params)
    {
        if (!$this->hasErrors()) // we only want to authenticate when no input errors
        {
            if (strpos($this->email, "@")) {
                $user = User::model()->findByAttributes(array('email' => $this->email));
                if ($user)
                    $this->user_id = $user->id;
            } else $user = null;

            if ($user === null)
                if (strpos($this->email, "@")) {
                    $this->addError("login_or_email", UserModule::t("Email is incorrect."));
                }
        }
    }

}