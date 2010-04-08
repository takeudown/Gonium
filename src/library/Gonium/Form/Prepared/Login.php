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
 * @package     Gonium_Form
 * @subpackage  Gonium_Form_Prepared
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Form */
require_once 'Gonium/Form.php';

/**
 * @package     Gonium_Form
 * @subpackage  Gonium_Form_Prepared
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_Form_Prepared_Login extends Gonium_Form {
    /**
     * Get a Login Form
     */
    public function init()
    {
        
        $this->addElements(array(
            'username' => array('text', array(
                'label' => _('loginForm_Username'),
                'id' => 'userForm-username',
                'size' => 11,
                'required' => true
            )),
            'password' => array('password', array(
                'label' => _('loginForm_Password'),
                'id' => 'userForm-password',
                'size' => 11
            )),
            'remember' => array('checkbox', array(
                'label' => _('loginForm_Remember'),
                'id' => 'userForm-remember',
            )),
            'submit' => array('submit', array(
                'label' => _('loginForm_Login'),
                'id' => 'userForm-login',
            ))
        ));

        
        $this->username->setAutoInsertNotEmptyValidator(false);
        //$form->username->setAllowEmpty(false);

        $this->username->addValidators(array(
                array('NotEmpty'),
                //array('alnum')
                //array('stringLength', false, array(6))
            )
        );
        
        $this->password->addValidators(array(
                array('NotEmpty'),
                //array('alnum')
                //array('stringLength', false, array(6))
            )
        );

        return $this;
    }

}