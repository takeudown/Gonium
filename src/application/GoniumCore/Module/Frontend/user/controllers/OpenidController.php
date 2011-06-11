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
 * @package     GoniumCore_Module_Frontend
 * @subpackage  GoniumCore_Module_Frontend_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see GoniumCore_Model_User */
require_once 'GoniumCore/Model/User.php';
/** @see Gonium_Auth_Storage_UserSession */
require_once 'Gonium/Auth/Storage/UserSession.php';

/**
 * Authenticate users through Openid
 * 
 * @package     GoniumCore_Module_Frontend
 * @subpackage  GoniumCore_Module_Frontend_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class User_OpenidController extends Zend_Controller_Action
{
    public function init ()
    {
        $this->_helper->viewRenderer->setScriptAction('index');
        $this->translate = Zend_Registry::get('Zend_Translate');
    }
    
    public function indexAction ()
    {
        return $this->loginAction();
    }
    
    protected function authenticate ($username, $password)
    {
        // Get a reference to the Singleton instance of Zend_Auth
        require_once 'Zend/Auth.php';
        $auth = Zend_Auth::getInstance();
        $dbAdapter = Zend_Registry::get('GoniumCore_Db');
        $userModel = $this->_helper->LoadModel('User');
        
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
    
    /**
     * @todo add storage, and associate with an username
     */
    public function loginAction ()
    {
        Zend_Loader::loadClass('Gonium_Form_Prepared_OpenId');
        $form = new Gonium_Form_Prepared_OpenId();
        $form->setAction(
        (string) $this->view->url(
        array('module' => 'user', 'controller' => 'openid', 'action' => 'login'), 
        null, true));
        $form->setElementPrefixId('mod_user-');
        $form->setAttrib('class', 'user-auth-form');
        $form->openid_url->setAttrib('size', 30);
        
        require_once "Zend/OpenId/Consumer.php";
        $consumer = new Zend_OpenId_Consumer();
        
        if (! $this->getRequest()->isPost() || ! $form->isValid($_POST))
        {
            echo $form;
            return;
        } else 
            if (! $consumer->login($form->openid_url->getValue()))
            {
                echo "OpenID login failed.<br>";
            } else 
                if (isset($_GET['openid_mode']))
                {
                    if ($_GET['openid_mode'] == "cancel")
                    {
                        echo "CANCELED<br>\n";
                    } else 
                        if ($this->_request->getParam('openid_mode') == 'id_res')
                        {
                            if (! $consumer->verify($_GET))
                            {
                                echo "INVALID ID<br>\n";
                            } else
                            {
                                echo "VALID ID<br>\n";
                            }
                        }
                }
        
        /** ON SUCCESS:
            $userModel = $this->_helper->LoadModel('User/Openid');
            $user = new Gonium_User();
            $user->setId($userModel->getID($resultAuth->getIdentity()));
            $user->setRoleId('uid-' . $userModel->getID());
         */
        
        return;
        /*
		require_once 'Zend/Auth/Storage/Session.php';
		
		$resultAuth = $this->authenticate ( $_POST ['username'], $_POST ['password'] );
		$resultAuth->getIdentity ();
		
		switch ($resultAuth->getCode ()) {
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
				// do stuff for nonexistent identity
				echo $this->translate->_ ( 'userLogin_IndentityNotFound' );
				echo $form;
				break;
			
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
				// do stuff for invalid credential
				echo $this->translate->_ ( 'userLogin_FailureCredentialInvalid' );
				echo $form;
				break;
			
			case Zend_Auth_Result::SUCCESS :
				
				$this->view->headMeta ()->appendHttpEquiv ( 'Refresh', '3;' . $this->view->url ( array (), null, true ) );
				
				echo $this->translate->_ ( 'userLogin_Success' );
				break;
			
			default :
				// do stuff for other failure
				break;
		}
		*/
    }
    
    public function logoutAction ()
    {
        $this->view->headMeta()->appendHttpEquiv('Refresh', 
        '3;' . $this->view->url(array(), null, true));
        
        echo $this->translate->_('userLogin_SignedOut');
        
        Zend_Auth::getInstance()->clearIdentity();
    }
}
