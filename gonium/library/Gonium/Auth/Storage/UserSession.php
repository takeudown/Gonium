<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 *  Copyright (C) 2008 Gonzalo Diaz Cruz
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
 * @package     Gonium_Auth
 * @subpackage  Gonium_Auth_Storage
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Auth_Storage_Interface */
require_once 'Zend/Auth/Storage/Interface.php';
/** Zend_Session_Namespace */
require_once 'Zend/Session/Namespace.php';
/** @see Gonium_User */
require_once 'Gonium/User.php';

/**
 * Zend_Auth storage adapter for PHP Session.
 *
 * @package     Gonium_Auth
 * @subpackage  Gonium_Auth_Storage
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_Auth_Storage_UserSession
    implements Zend_Auth_Storage_Interface
{
    /**
     * Default session namespace
     */
    const NAMESPACE_DEFAULT = 'Zend_Auth';

    /**
     * Default session object member name
     */
    const MEMBER_DEFAULT = 'storage';

    /**
     * Object to proxy $_SESSION storage
     *
     * @var Zend_Session_Namespace
     */
    protected $_session;

    /**
     * Session namespace
     *
     * @var mixed
     */
    protected $_namespace;

    /**
     * Session object member
     *
     * @var mixed
     */
    protected $_member;
    
    /**
     * Throw Exceptions?
     */
    protected $_throwExceptions = false;

    /**
     * Sets session storage options and initializes session namespace object
     *
     * @param  mixed $namespace
     * @param  mixed $member
     * @return void
     */
    public function __construct($namespace = self::NAMESPACE_DEFAULT, $member = self::MEMBER_DEFAULT)
    {
        $this->_namespace = $namespace;
        $this->_member    = $member;
        $this->_session   = new Zend_Session_Namespace($this->_namespace);
    }

    /**
     * Returns the session namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->_namespace;
    }

    /**
     * Returns the name of the session object member
     *
     * @return string
     */
    public function getMember()
    {
        return $this->_member;
    }
    
    public function throwExceptions($boolean)
    {
    	$this->_throwExceptions = (boolean) $boolean;
    }
    
    // Zend_Auth_Storage_Interface:

    /**
     * If not has user data or is default guest user, returns true.
     * If has user data of 
     * Defined by Zend_Auth_Storage_Interface
     *
     * @return boolean
     */
    public function isEmpty()
    {
        return
               // si el miembro no existe
               !( isset($this->_session->{$this->_member}) )
               // o si el miembro no es un Gonium_User
            || !( $this->_session->{$this->_member} instanceof Gonium_User )
               // o si los datos son los de un usuario "guest"
            || ( $this->_session->{$this->_member}->isDefault() )
            ;
    }

    /**
     * Defined by Zend_Auth_Storage_Interface
     *
     * @return mixed
     */
    public function read()
    {
        return $this->_session->{$this->_member};
    }

    /**
     * Defined by Zend_Auth_Storage_Interface
     *
     * @param  mixed $contents
     * @return void
     */
    public function write($contents)
    {
        if($contents instanceof Gonium_User)
        {
        	$this->_session->{$this->_member} = $contents;
        } else
        if($this->_throwExceptions){
        	throw new Gonium_Auth_Exception('User data does\'t provided');
        }
    }

    /**
     * Defined by Zend_Auth_Storage_Interface
     *
     * @return void
     */
    public function clear()
    {
        unset($this->_session->{$this->_member});
    }

}

