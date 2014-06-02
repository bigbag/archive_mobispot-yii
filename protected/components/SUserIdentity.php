<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class SUserIdentity extends CUserIdentity
{

    private $_id;
    private $_email;

    const ERROR_EMAIL_INVALID = 3;
    const ERROR_STATUS_NOTACTIV = 4;
    const ERROR_STATUS_BAN = 5;

    public function __construct($email)
    {
        $this->_email = $email;
    }

    public function authenticate()
    {
        $user = User::model()->findByAttributes(array('email' => $this->_email));

        if ($user === null)
            $this->errorCode = self::ERROR_EMAIL_INVALID;
        else if ($user->status == User::STATUS_NOACTIVE)
            $this->errorCode = self::ERROR_STATUS_NOTACTIV;
        else if ($user->status == User::STATUS_BANNED)
            $this->errorCode = self::ERROR_STATUS_BAN;
        else {
            $this->_id = $user->id;
            $this->_email = $user->email;
            $this->username = $user->email;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    /**
     * @return integer the ID of the user record
     */
    public function getId()
    {
        return $this->_id;
    }

    public function getEmail()
    {
        return $this->_email;
    }

}
