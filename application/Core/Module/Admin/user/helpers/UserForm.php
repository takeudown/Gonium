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
 * @package     Core_Module_Admin
 * @subpackage  Core_Module_Admin_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/**
 * @package     Core_Module_Admin
 * @subpackage  Core_Module_Admin_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Core_Module_Admin_User_Helper_UserForm 
    extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * @return Rox_Form_Table
	 */
    public function createUserForm()
    {
    	Zend_Loader::loadClass('Rox_Form_Table');
    	
    	$form = new Rox_Form_Table(array(
            'elements' => array(
                'username' => array('text', array(
                    'required' => true,
                    'label' => _('username'),
                    'size' => 30
                )),
                'password' => array('password', array(
                    'required' => true,
                    'label' => _('password'),
                    'size' => 30
                )),
                'password_confirm' => array('password', array(
                    'required' => true,
                    'label' => _('confirm password'),
                    'size' => 30
                )),
                'submit' => array('submit', array(
                    'label' => _('Add User'),
                    'id' => null
                ))
            ),
            'id' => 'storemanager-order'
        ));
        
        $form->password->addValidator(
            new Rox_Validate_PasswordConfirmation()
        );
        
        return $form;
    }
    
    public function direct(){
    	return $this;
    }
}