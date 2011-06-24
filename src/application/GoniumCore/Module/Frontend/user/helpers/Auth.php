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
 * @package     
 * @subpackage  
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_User */
require_once 'Gonium/User.php';

include_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * Configure paths to Controller Action Helpers
 *
 * @package     
 * @subpackage  
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Module_Frontend_User_Helper_Auth extends Zend_Controller_Action_Helper_Abstract
{

    public function direct ()
    {
        return $this;
    }

    public function getCookieStorage ()
    {
        // Check cookie for login
        Zend_Loader::loadClass('Gonium_Crypt_HmacCookie');
        Zend_Loader::loadClass('Gonium_Auth_Storage_SecureCookie');
        $hmacCookie = new Gonium_Crypt_HmacCookie($config->system->key, 
        array('high_confidentiality' => true, 'enable_ssl' => true));
        $bUrl = $this->getRequest()->getBaseUrl();
        $bUrl = $bUrl != '' ? $bUrl : '/';
        $cookieAuth = new Gonium_Auth_Storage_SecureCookie($hmacCookie, 
        array('cookieName' => $config->system->cookie->name_prefix . 'Auth', 
            'cookieExpire' => (time() + $config->system->cookie->expire), 
            'cookiePath' => $bUrl));
        return $cookieAuth;
    }

    public function remember (Gonium_User $user)
    {
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
        $config = Zend_Registry::get('GoniumCore_Config');
        
        // Set a secure cookie
        $hmacCookie = new Gonium_Crypt_HmacCookie($config->system->key, 
        array('high_confidentiality' => true, 'enable_ssl' => true));
        
        $bUrl = $this->getRequest()->getBaseUrl();
        $bUrl = $bUrl != '' ? $bUrl : '/';
        
        $cookieAuth = new Gonium_Auth_Storage_SecureCookie($hmacCookie, 
        array('cookieName' => $config->system->cookie->name_prefix . 'Auth', 
            'cookieExpire' => (time() + $config->system->cookie->expire), 
            'cookiePath' => $bUrl));
        
        $auth->clearIdentity();
        $auth->setStorage($cookieAuth);
        $auth->getStorage()->write($user);
    
    }

    public function authenticate ($username, $password, $userModel)
    {
        // Get a reference to the Singleton instance of Zend_Auth
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
        $dbAdapter = Zend_Registry::get('GoniumCore_Db');
        
        require_once 'Zend/Auth/Adapter/DbTable.php';
        // Configure the instance with setter methods
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName($userModel->_name)
            ->setIdentityColumn($userModel->getIdentityColumn())
            ->setCredentialColumn($userModel->getCredentialColumn());
        
        // Set the input credential values (e.g., from a login form)
        $authAdapter->setIdentity($username)->setCredential(
            sha1($password));
        
        // Perform the authentication query, saving the result
        return $auth->authenticate($authAdapter);
    }

    public function activate ($uid, $code, $userModel)
    {
        // Get a reference to the Singleton instance of Zend_Auth
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
        $dbAdapter = Zend_Registry::get('GoniumCore_Db');
        
        require_once 'Zend/Auth/Adapter/DbTable.php';
        // Configure the instance with setter methods
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName($userModel->_name)
            ->setIdentityColumn($userModel->getIDColumn())
            ->setCredentialColumn($userModel->getActivationCodeColumn());
        
        // Set the input credential values (e.g., from a login form)
        $authAdapter->setIdentity($uid)->setCredential(sha1($code));
        
        // Perform the authentication query, saving the result
        return $auth->authenticate($authAdapter);
    }
}