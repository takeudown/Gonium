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
 * @package     Bootstrap
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_ACL */
require_once 'Gonium/ACL.php';
/** @see Gonium_User */
require_once 'Gonium/User.php';

/** Core_Model_ACL_Roles */
require_once 'Core/Model/ACL/Roles.php';        // Who have the access
/** Core_Model_ACL_Access */
require_once 'Core/Model/ACL/Access.php';        // Rules of access
/** Core_Model_ACL_Resources */
require_once 'Core/Model/ACL/Resources.php';        // Resources to access
/** Core_Model_User */
require_once 'Core/Model/User.php';

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Initialize User data
 * User session and ACL privileges.
 *
 * @package     Bootstrap
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Init_Plugin_User extends Zend_Controller_Plugin_Abstract
{
    function routeStartup(Zend_Controller_Request_Abstract $request)
    {
    	parent::routeStartup($request);
    	Zend_Loader::loadClass('Zend_Auth');
        Zend_Loader::loadClass('Zend_Session_Namespace');
        Zend_Loader::loadClass('Gonium_Controller_Action_Helper_LoadModel');
        $config = Zend_Registry::get('core_config');

        // Session data of user
        $userNamespace = new Zend_Session_Namespace('user');

        // Si la sesion no existe o fue destruida (logout),
        // generar un id de sesion nuevo
        if (!isset($userNamespace->initialized)) {
            Zend_Session::regenerateId();
            $userNamespace->initialized = true;
        }

        // Check cookie for login
        Zend_Loader::loadClass('Gonium_Crypt_HmacCookie');
        Zend_Loader::loadClass('Gonium_Auth_Storage_SecureCookie');

        $auth = Zend_Auth::getInstance();
        Zend_Registry::set('core_auth',  $auth);

        $hmacCookie = new Gonium_Crypt_HmacCookie($config->system->key, array(
            'high_confidentiality' => true,
            'enable_ssl' => true
        ));

        $bUrl = $this->getRequest()->getBaseUrl();
        $bUrl = $bUrl != '' ? $bUrl : '/';

        $cookieAuth = new Gonium_Auth_Storage_SecureCookie($hmacCookie, array(
                'cookieName' => 'RoxAuth',
                'cookieExpire' => (time() + 86400),
                'cookiePath' => $bUrl
            ));

        $auth->setStorage($cookieAuth);

        if(!$auth->hasIdentity())
        {
            Zend_Loader::loadClass('Gonium_Auth_Storage_UserSession');
            $auth->setStorage(new Gonium_Auth_Storage_UserSession('user', 'data') );

            //var_dump($auth->getIdentity());
        }

        // ACL
        $acl = new Gonium_ACL();
        Zend_Registry::set('core_acl', $acl);

        ////////////// TESTING AREA:
        // @todo change everything:

        $user = $auth->getIdentity();
        if( !($user instanceof Gonium_User) )
        {
        	$auth->clearIdentity();
        }

        $user = new Gonium_User();

        //var_dump($_SESSION);

        //$userTable = Gonium_Controller_Action_Helper_LoadModel::getModel('User');

        //$roles = Gonium_Controller_Action_Helper_LoadModel::getModel('ACL_Roles');
        //var_dump($roles->getRoles());

        require_once 'Zend/Acl.php';
        $acl = new Zend_Acl();

        // Principal Roles
        $acl->addRole(new Zend_Acl_Role('member'));
        $acl->addRole(new Zend_Acl_Role('admin'));

        $parents = array();

        require_once 'Zend/Acl/Role.php';
        if( $user->getRoleId() != 'guest' )
        {
            $acl->addRole( new Zend_Acl_Role('guest'));

            // Principal Parents
            $parents = array('guest','member', 'admin');

        }

        $acl->addRole( $user, $parents );

        // Verificar sesion

        //$acl->addRole(new Zend_Acl_Role('moderator'), $parents);

        //$acl->removeRole( 'guest' );

        //$acl->addRole( $user /*, $parents*/ );

        require_once 'Zend/Acl/Resource.php';
        $acl->add(new Zend_Acl_Resource('someResource'));

        $acl->deny('guest', 'someResource');
        $acl->allow('member', 'someResource');

        //var_dump( $acl->isAllowed( $user, 'someResource') );

        //var_dump( $_SESSION );
        //var_dump($acl);
        //var_dump($user);
        //var_dump($user->isAuthenticated());
        //die();
    }
}