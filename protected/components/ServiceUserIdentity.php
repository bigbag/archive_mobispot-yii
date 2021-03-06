<?php

class ServiceUserIdentity extends CUserIdentity
{

    const ERROR_NOT_AUTHENTICATED = 3;

    private $_id;
    private $_email;
    private $_password;
    private $_profileUrl;

    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;

    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Authenticates a user based on {@link username}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {

        // $user = User::model()->findByAttributes(array('email' => $this->service->email));

        if ($this->service->isAuthenticated) {
            $this->_id = $this->service->getAttribute('id');
            $this->_profileUrl = $this->service->getAttribute('url');
            $this->errorCode = self::ERROR_NONE;
        } else {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
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

    public function getPassword()
    {
        return $this->_password;
    }

    public function getProfileUrl()
    {
        return $this->_profileUrl;
    }

}
