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
 * @package     User
 * @subpackage  User_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Widget */
require_once 'Gonium/Widget.php';

/**
 * @package     User
 * @subpackage  User_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Widget_Login extends Gonium_Widget {

	public function execute() {
		$auth = Zend_Registry::get ( 'GoniumCore_auth' );
		$view = Zend_Registry::get ( 'GoniumCore_view' );
		//$lang = Zend_Registry::get ( 'Zend_Translate' );

		if ( !$auth->hasIdentity() )
		{
			try {
				Zend_Loader::loadClass ( 'Gonium_Form_Prepared_Login' );
				$form = new Gonium_Form_Prepared_Login ( );
				$form->setStyle('Div');
				$form->setAttrib ( 'id', 'widget-user-auth' );
				$form->setAttrib ( 'class', 'widget-auth-form' );
				$form->setAction ( ( string ) $view->url ( array ('module' => 'user', 'controller' => 'auth', 'action' => 'login' ), null, true ) );
				$this->_view->assign('loginForm', $form );

				Zend_Loader::loadClass ( 'Gonium_Form_Prepared_OpenId' );
				$openidForm = new Gonium_Form_Prepared_OpenId();
				$openidForm->setStyle('Div');
				$openidForm->setAttrib ( 'class', 'widget-auth-form openid' );
				$openidForm->setAction ( ( string ) $view->url ( array( 'module'=> 'user' , 'controller' => 'openid', 'action' => 'login' ), null, true ) );
				$this->_view->assign('openidForm', $openidForm );

				$this->setContent( $this->_view->render('forms.phtml') );

			} catch ( Exception $e ) {
				Gonium_Exception::dump($e);
				trigger_error( $e->getMessage(), E_USER_ERROR);
			}
		} else {
			Zend_Loader::loadClass ( 'Gonium_Form_Prepared_Logout' );
			$form = new Gonium_Form_Prepared_Logout ( );
			$form->setStyle('Div');
			$form->setAttrib ( 'id', 'widget-user-auth' );
			$form->setAction ( ( string ) $view->url ( array ('module' => 'user', 'controller' => 'auth', 'action' => 'logout' ), null, true ) );

			$this->setContent( ( string ) $form ); //'<a href="' . $view->url ( array ('module' => 'user', 'controller' => 'auth', 'action' => 'logout' ), null, true ) . '">' . $lang->translate ( 'loginForm_Logout' ) . '</a>';
		}
	}
}