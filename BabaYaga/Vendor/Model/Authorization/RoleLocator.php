<?php

namespace BabaYaga\Vendor\Model\Authorization;

class RoleLocator implements \Magento\Framework\Authorization\RoleLocatorInterface
{
    /**
     * Authentication service
     *
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $_session;

    /**
     * @param \Magento\Backend\Model\Auth\Session $session
     */
    public function __construct(\Magento\Backend\Model\Auth\Session $session)
    {
        $this->_session = $session;
    }

    /**
     * Retrieve current role
     *
     * @return string|null
     */
    public function getAclRoleId()
    {
        return 4; // baba - authorization_role -> authorization_rule
    }
}
