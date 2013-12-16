<?php

/**
 * EAuthUserIdentity class file.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EAuthUserIdentity is a base User Identity class to authenticate with EAuth.
 * @package application.extensions.eauth
 */
class CEAuthUserIdentity extends CBaseUserIdentity
{

    const ERROR_NOT_AUTHENTICATED = 3;

    /**
     * @var EAuthServiceBase the authorization service instance.
     */
    protected $service;

    /**
     * @var string the unique identifier for the identity.
     */
    protected $id;

    /**
     * @var string email
     */
    protected $email;

    /**
     * Constructor.
     * @param EAuthServiceBase $service the authorization service instance.
     */
    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Authenticates a user based on {@link service}.
     * This method is required by {@link IUserIdentity}.
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        if ($this->service->isAuthenticated)
        {

            $this->id = $this->service->id;
            $this->email = $this->service->getAttribute('email');

            if (!$this->email && $this->service->serviceName === 'twitter')
            {
                $find = User::model()->findByAttributes(array($this->service->serviceName . '_id' => $this->id));
                if ($find)
                    $this->email = $find->email;
            }

            $this->setState('id', $this->id);
            $this->setState('service', $this->service->serviceName);
            $this->setState('email', $this->email);

            $this->errorCode = self::ERROR_NONE;
        } else
        {
            $this->errorCode = self::ERROR_NOT_AUTHENTICATED;
        }
        return !$this->errorCode;
    }

    /**
     * Returns the unique identifier for the identity.
     * This method is required by {@link IUserIdentity}.
     * @return string the unique identifier for the identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the display name for the identity.
     * This method is required by {@link IUserIdentity}.
     * @return string the display name for the identity.
     */
    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

}