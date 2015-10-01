<?php
use Nette\Security\IIdentity;
use Nette\Security\IUserStorage;

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28.06.15
 * Time: 15:28
 */
class DummyUserStorage implements IUserStorage
{

    private $authenticated;

    private $identity;

    public function setAuthenticated($state)
    {
        $this->authenticated = $state;
    }

    public function isAuthenticated()
    {
        return $this->authenticated;
    }

    public function getIdentity()
    {
        return $this->identity;
    }

    public function setIdentity(IIdentity $identity = null)
    {
        $this->identity = $identity;
    }

    public function setExpiration($time, $flags = 0)
    {
    }

    public function getLogoutReason()
    {
        return null;
    }

}