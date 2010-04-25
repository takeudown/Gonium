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
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Load Gettext translation adapter and configure user language.
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
    /**
    * @todo Configurar el idioma dependiendo de la preferencia del usuario,
    * o de las cabeceras del navegador.
    * @todo Create a LoadTranslation action/view helper
    */
	
	// Application Translations
	private	$options;
	
	public function __construct()
	{
		$this->options = array(
				'scan' => Zend_Translate::LOCALE_DIRECTORY,
				//'disableNotices'=> true//,
				'log' => new Zend_Log() // <- Zend_log without writer throws 
										// exceptions when a error ocurred
		);
	}
		
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
    	parent::routeStartup($request);
        Zend_Loader::loadClass('Zend_Translate');
		Zend_Loader::loadClass('Zend_Locale');
		
		try {
			$locale = new Zend_Locale('auto');
			$translate = new Zend_Translate(
				'gettext',
				APP_ROOT.'/language/',
				$locale,
				$this->options);
		} catch (Exception $e) {
			$locale = new Zend_Locale('en_US');
			$translate = new Zend_Translate(
				'gettext',
				APP_ROOT.'/language/',
				$locale,
				$this->options);
		}
		
		Zend_Registry::set('Zend_Translate', $translate);
		Zend_Registry::set('Zend_Locale', $locale);
    }
    
    public function predispatch(Zend_Controller_Request_Abstract $request)
    {
    	parent::predispatch($request);
    	
    	$translate = Zend_Registry::get('Zend_Translate');
    	$locale = Zend_Registry::get('Zend_Locale');
    	
    	// Home Translations
		try {		
			$translate->addTranslation(
				HOME_ROOT.'/language/',
				$locale,
				$this->options);
		} catch (Exception $e) {
			$translate->addTranslation(
				HOME_ROOT.'/language/',
				new Zend_Locale('en_US'),
				$this->options);
		}
    }
}