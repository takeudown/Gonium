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
 * @version     $Id: SiteInstaller.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** @see Gonium_Form */
require_once 'Gonium/Form.php';
/** @see Gonium_Form_Prepared_DbConnection */
require_once 'Gonium/Form/Prepared/DbConnection.php';

/**
 * @package     Gonium_Form
 * @subpackage  Gonium_Form_Prepared
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: SiteInstaller.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Form_Prepared_SiteInstaller extends Gonium_Form {
    /**
     * Get a Login Form
     */
    public function init()
    {
    	$DbConnection = new Gonium_Form_Prepared_DbConnection();

        $this->addElements(array(
            'site_name' => array('text', array(
                'label' => _('site_name'),
                'required' => true,
                'size' => 20
            )),
            'site_slogan' => array('text', array(
                'label' => _('site_slogan'),
                'required' => true,
                'size' => 20
            ))
        ));

		Zend_Loader::loadClass('Zend_Filter_StripTags');
		Zend_Loader::loadClass('Zend_Filter_StringTrim');
		Zend_Loader::loadClass('Zend_Filter_HtmlEntities');
		
        $stripTags = new Zend_Filter_StripTags();
        $stringTrim = new Zend_Filter_StringTrim();
        $htmlEntities = new Zend_Filter_HtmlEntities();
        $this->site_name->addFilter($stripTags);
        $this->site_name->addFilter($stringTrim);
        $this->site_name->addFilter($htmlEntities);

        $this->site_slogan->addFilter($stripTags);
        $this->site_slogan->addFilter($stringTrim);
        $this->site_slogan->addFilter($htmlEntities);

        $SiteKeys = array_keys($this->getElements());

        $this->addDisplayGroup(
            $SiteKeys,
            'SiteInformation',
            array('Legend'=> _('Site Information'))
        );

        $DbConnectionKeys = array_keys($DbConnection->getElements());

        $DbConnection->addDisplayGroup(
            $DbConnectionKeys,
            'DatabaseConnection',
            array('Legend'=> _('Database Connection'))
        );

        $this->addSubForm( $DbConnection, 'dbConnection');

        $this->addElement( 'submit', 'submit', array('label' => _('Try Install')) );


        return $this;
    }

}