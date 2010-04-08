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
class Gonium_Form_Prepared_DbConnection extends Gonium_Form {
    /**
     * Create a Database Connection Form
     */
    public function init()
    {
        $this->addElements(array(
            'dbadapter' => array('select', array(
                'label' => _('dbconnection_adapter'),
                'id' => 'dbconnection_adapter',
                'required' => true
            )),
            'dbhost' => array('text', array(
                'label' => _('dbconnection_dbhost'),
                'id' => 'dbconnection_dbhost',
                'required' => true,
                'size' => 20
            )),
            'dbport' => array('text', array(
                'label' => _('dbconnection_dbport'),
                'id' => 'dbconnection_dbport',
                'required' => true,
                'size' => 20
            )),
            'dbname' => array('text', array(
                'label' => _('dbconnection_dbname'),
                'id' => 'dbconnection_dbname',
                'required' => true,
                'size' => 20
            )),
            'dbprefix' => array('text', array(
                'label' => _('dbconnection_dbprefix'),
                'id' => 'dbconnection_dbprefix',
                'required' => true,
                'size' => 20,
                'value' => 'gonium_'
            )),
            'dbuser' => array('text', array(
                'label' => _('dbconnection_user'),
                'id' => 'dbconnection_user',
                'size' => 20
            )),
            'dbpass' => array('password', array(
                'label' => _('dbconnection_password'),
                'id' => 'dbconnection_password',
                'size' => 20
            )),
        ));

        $this->dbadapter->setMultiOptions(array(
            'mysqli' => 'mysqli',
            'pdo_mysql' => 'pdo_mysql',
            'pdo_pgsql' => 'pdo_pgsql'
        ));
        $this->dbadapter->setValue('pdo_mysql');

		Zend_Loader::loadClass('Zend_Filter_StringTrim');
        $stringTrim = new Zend_Filter_StringTrim();
        $this->dbhost->addFilter($stringTrim);
        $this->dbname->addFilter($stringTrim);
        $this->dbuser->addFilter($stringTrim);
        $this->dbpass->addFilter($stringTrim);


        return $this;
    }

}