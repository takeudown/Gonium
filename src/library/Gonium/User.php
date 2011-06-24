<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 * Copyright (C) 2008 Gonzalo Diaz Cruz
 *
 * LICENSE
 *
 * Gonium is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any
 * later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category    Gonium
 * @package     Gonium_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Acl_Role_Interface */
require_once 'Zend/Acl/Role/Interface.php';

/**
 * Represents the identity of a user
 *
 * @category    Gonium
 * @package     Gonium_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_User implements Zend_Acl_Role_Interface
{

    protected $_ID;
    protected $_Role;
    
    /**
     * 
     */
    public function __construct ($id = null)
    {
        if ($id != null && is_scalar($id))
        {
            $this->setId($id);
            $this->setRoleId('uid-' . $id);
        }
    }
    
    /**
     * Set user ID
     *
     * @return Gonium_User
     */
    public function setId ($id)
    {
        if (is_scalar($id)) $this->_ID = $id;
        else
            throw new Exception(
            'Invalid user ID supplied. Must be a scalar data');
        
        return $this;
    }
    
    /**
     * Return user ID
     *
     * @return integer
     */
    public function getId ()
    {
        return $this->_ID;
    }
    
    /**
     * Asociate a Role ID to the user
     *
     * @return Gonium_User
     */
    public function setRoleId ($role)
    {
        if (is_scalar($role) || $role instanceof Zend_Acl_Role_Interface) $this->_Role = $role;
        else
            throw new Exception(
            'Invalid user ID supplied. Must be a scalar data');
        
        return $this;
    }
    
    /**
     * Return Role ID asociated to the user
     *
     * @return string
     */
    public function getRoleId ()
    {
        return $this->_Role;
    }
    
    /**
     * Set default user data
     *
     * @return Gonium_User
     */
    public function setDefault ()
    {
        $this->setId(0);
        $this->setRoleId('guest');
        
        return $this;
    }
    
    /**
     * Return true if user has "guest" role.
     *
     * @return boolean
     */
    public function isDefault ()
    {
        return (boolean) ($this->_Role == 'guest');
    }
}