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
 * @package     Core_Module_Frontend
 * @subpackage  Core_Module_Frontend_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: AuthController.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Core_Model_User */
require_once 'Core/Model/User.php';
/** @see Rox_Auth_Storage_UserSession */
require_once 'Rox/Auth/Storage/UserSession.php';

/**
 * @package     Core_Module_Frontend
 * @subpackage  Core_Module_Frontend_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: AuthController.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class User_AuthController extends Zend_Controller_Action {
    public function init()
    {
        $this->_helper->viewRenderer->setScriptAction('index');
        $this->translate = Zend_Registry::get('Zend_Translate');
    }

    public function indexAction()
    {
        return $this->loginAction();
    }

    protected function authenticate($username, $password)
    {
        // Get a reference to the Singleton instance of Zend_Auth
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
        $dbAdapter = Zend_Registry::get('core_db');
        $userModel = $this->_helper->LoadModel('User');

        require_once 'Zend/Auth/Adapter/DbTable.php';
        // Configure the instance with setter methods
        $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
        $authAdapter->setTableName($userModel->_name)
                    ->setIdentityColumn( $userModel->getIdentityColumn() )
                    ->setCredentialColumn( $userModel->getCredentialColumn() );

        // Set the input credential values (e.g., from a login form)
        $authAdapter->setIdentity($username)
                    ->setCredential( sha1($password) );

        // Perform the authentication query, saving the result
        return $auth->authenticate($authAdapter);
    }

    public function loginAction()
    {
        $config = Zend_Registry::get('core_config');
        /*
        $user = new Rox_User();
        $user->setId('1');
        $user->setRoleId('uid-1');

        $manager = new Rox_Crypt_HmacCookie($config->system->key, array(
          'high_confidentiality' => true,
          'enable_ssl' => true)
        );
        $manager->setCookie('myAuth', $user, 'username', time() + 86400, $this->getRequest()->getBaseUrl());
        */

        Zend_Loader::loadClass('Rox_Form_Prepared_Login');
        $form = new Rox_Form_Prepared_Login();
        $form->setStyle('Table');
        $form->setAction( (string) $this->view->url(
            array(
                'module'=> 'user' ,
                'controller' => 'auth',
                'action' => 'login'
            )
            , null, true ));
        $form->setAttrib('class', 'user-auth-form');
        $form->setElementPrefixId('mod_user-');

        if ( !$this->getRequest()->isPost()
            || !$form->isValid( $this->_request->getPost() )
        )  {
            echo $form;
            return;
        }

        $resultAuth = $this->authenticate(
             $this->_request->getPost('username'),
             $this->_request->getPost('password')
         );
        $resultAuth->getIdentity();

        switch ($resultAuth->getCode()) {
            case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
                // do stuff for nonexistent identity
                echo $this->translate->_('userLogin_IndentityNotFound');
                echo $form;
            break;

            case  Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                // do stuff for invalid credential
                echo $this->translate->_('userLogin_FailureCredentialInvalid');
                echo $form;
            break;

            case Zend_Auth_Result::SUCCESS:
                $auth = Zend_Auth::getInstance();
                $config = Zend_Registry::get('core_config');
                $userModel = $this->_helper->LoadModel('User');

                $id = $userModel->getID($resultAuth->getIdentity());
                $user = new Rox_User();
                $user->setId($id);
                $user->setRoleId('uid-' . $id);


                //var_dump($auth->getStorage());

                // Remember?
                if($form->remember->getValue() === '1')
                {
                    // Set a secure cookie
                    $hmacCookie = new Rox_Crypt_HmacCookie($config->system->key, array(
                        'high_confidentiality' => true,
                        'enable_ssl' => true
                    ));

                    $bUrl = $this->getRequest()->getBaseUrl();
                    $bUrl = $bUrl != '' ? $bUrl : '/';
                
                    $cookieAuth = new Rox_Auth_Storage_SecureCookie($hmacCookie, array(
                            'cookieName' => 'RoxAuth',
                            'cookieExpire' => (time() + 86400),
                            'cookiePath' => $bUrl
                        ));

                    $auth->clearIdentity();
                    $auth->setStorage($cookieAuth);

                }

                $auth->getStorage()->write($user);

                $this->view->headMeta()->appendHttpEquiv(
                    'Refresh', '3;' . $this->view->url( array(), null, true)
                );

                echo $this->translate->_('userLogin_Success');
            break;

            default:
                // do stuff for other failure
            break;
        }
    }

    public function logoutAction()
    {
        $this->view->headMeta()->appendHttpEquiv(
            'Refresh', '3;'. $this->view->url( array(), null, true)
        );

        echo $this->translate->_('userLogin_SignedOut');

        Zend_Auth::getInstance()->clearIdentity();
        $config = Zend_Registry::get('core_config');
        $hmacCookie = new Rox_Crypt_HmacCookie($config->system->key, array(
                        'high_confidentiality' => true,
                        'enable_ssl' => true
                    ));
        $hmacCookie->deleteCookie('RoxAuth', $this->getRequest()->getBaseUrl());
    }
}
