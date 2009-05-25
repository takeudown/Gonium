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
 * @version     $Id: OpenId.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** @see Gonium_Form */
require_once 'Gonium/Form.php';

/**
 * @package     Gonium_Form
 * @subpackage  Gonium_Form_Prepared
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: OpenId.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Form_Prepared_OpenId extends Gonium_Form {
    /**
     * Get a Login Form
     */
    public function init()
    {
        
        $this->addElements(array(
            'openid_url' => array('text', array(
                'label' => _('loginForm_OpenId_Url'),
                'id' => 'openidForm-url',
                'class' => 'openid_url',
                'value' => 'http://',
                'size' => 10,
                'required' => true,
            )),
            'remember' => array('checkbox', array(
                'label' => _('loginForm_Remember'),
                'id' => 'openidForm-remember',
            )),
            'submit' => array('submit', array(
                'label' => _('loginForm_Login'),
                'id' => 'openidForm-login'
            ))
        ));

        $this->openid_url->setAutoInsertNotEmptyValidator(false);
        //$form->username->setAllowEmpty(false);

        $this->openid_url->addValidators(array(
                array('NotEmpty')
            )
        );
        
        Zend_Loader::loadClass('Gonium_Validate_Uri');
        $this->openid_url->addValidator(new Gonium_Validate_Uri());

        return $this;
    }

}