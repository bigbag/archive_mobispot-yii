<?php

class LoginForm extends CFormModel
{

    public $email;
    public $terms;
    public $password;
    public $rememberMe;
    public $activ_code;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // email and password are required
            array('email, terms', 'required'),
            array('email', 'email'),
            array('email, password', 'filter', 'filter' => 'trim'),
            // rememberMe needs to be a boolean
            array('rememberMe', 'boolean'),
            // password needs to be authenticated
            array('password', 'authenticate'),
            array('activ_code, rememberMe, password, terms, email', 'safe'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'rememberMe' => Yii::t('user', "Remember me next time"),
            'email' => Yii::t('user', "Email"),
            'password' => Yii::t('user', "password"),
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors())
        { // we only want to authenticate when no input errors
            $identity = new UserIdentity($this->email, $this->password);
            $identity->authenticate();
            switch ($identity->errorCode)
            {
                case UserIdentity::ERROR_NONE:
                    $duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 days
                    Yii::app()->user->login($identity, $duration);
                    break;
                case UserIdentity::ERROR_EMAIL_INVALID:
                    $this->addError("email", Yii::t('user', "Email is incorrect."));
                    break;
                case UserIdentity::ERROR_STATUS_NOTACTIV:
                    $this->addError("status", Yii::t('user', "You account is not activated."));
                    break;
                case UserIdentity::ERROR_STATUS_BAN:
                    $this->addError("status", Yii::t('user', "You account is blocked."));
                    break;
                case UserIdentity::ERROR_PASSWORD_INVALID:
                    $this->addError("password", Yii::t('user', "Password is incorrect."));
                    break;
            }
        }
    }

}
