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
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_ACL */
require_once 'Gonium/ACL.php';
/** @see Gonium_User */
require_once 'Gonium/User.php';

/** GoniumCore_Model_ACL_Roles */
require_once 'GoniumCore/Model/ACL/Role.php'; // Who have the access
/** GoniumCore_Model_ACL_Access */
require_once 'GoniumCore/Model/ACL/Access.php'; // Rules of access
/** GoniumCore_Model_ACL_Resources */
require_once 'GoniumCore/Model/ACL/Resource.php'; // Resources to access
/** GoniumCore_Model_User */
require_once 'GoniumCore/Model/User.php';

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Initialize User data
 * User session and ACL privileges.
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Plugin_User extends Zend_Controller_Plugin_Abstract
{

    function routeStartup (Zend_Controller_Request_Abstract $request)
    {
        parent::routeStartup($request);
        Zend_Loader::loadClass('Zend_Auth');
        Zend_Loader::loadClass('Zend_Session_Namespace');
        Zend_Loader::loadClass('Gonium_Controller_Action_Helper_LoadModel');
        $config = Zend_Registry::get('GoniumCore_Config');
        
        // Session data of user
        $userNamespace = new Zend_Session_Namespace('user');
        
        // Si la sesion no existe o fue destruida (logout),
        // generar un id de sesion nuevo
        if (! isset($userNamespace->initialized))
        {
            Zend_Session::regenerateId();
            $userNamespace->initialized = true;
        }
        
        // Check cookie for login
        Zend_Loader::loadClass('Gonium_Crypt_HmacCookie');
        Zend_Loader::loadClass('Gonium_Auth_Storage_SecureCookie');
        
        $hmacCookie = new Gonium_Crypt_HmacCookie($config->system->key, 
            array('high_confidentiality' => true, 'enable_ssl' => true));
        
        $bUrl = $this->getRequest()->getBaseUrl();
        $bUrl = $bUrl != '' ? $bUrl : '/';
        
        $cookieAuth = new Gonium_Auth_Storage_SecureCookie($hmacCookie, 
            array('cookieName' => 'GoniumAuth', 
                'cookieExpire' => (time() + 86400), 'cookiePath' => $bUrl));
        
        Zend_Loader::loadClass('Gonium_Auth_Storage_UserSession');
        // Save a reference to the Singleton instance of Zend_Auth
        $auth = Zend_Auth::getInstance();
        $auth->setStorage($cookieAuth);
        
        if (! $auth->hasIdentity())
        {
            Zend_Loader::loadClass('Gonium_Auth_Storage_UserSession');
            $auth->setStorage(
                new Gonium_Auth_Storage_UserSession('user', 'data'));
        
     //var_dump($auth->getIdentity());
        }
        
        // ACL
        $acl = new Gonium_ACL();
        Zend_Registry::set('GoniumCore_Acl', $acl);
        
        ////////////// TESTING AREA:
        // @todo change everything:
        

        $user = $auth->getIdentity();
        if (! ($user instanceof Gonium_User))
        {
            $auth->clearIdentity();
        }
        
        $user = new Gonium_User();
    
     //var_dump($_SESSION);
    

    //$userTable = Gonium_Controller_Action_Helper_LoadModel::getModel('User');
    

    //$roles = Gonium_Controller_Action_Helper_LoadModel::getModel('ACL_Roles');
    //var_dump($roles->getRoles());
    

    }
}