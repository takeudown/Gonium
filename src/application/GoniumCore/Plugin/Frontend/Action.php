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
 * @subpackage  Plugin_Frontend
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Configure paths to Controller Action Helpers
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Plugin_Frontend_Action extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        parent::dispatchLoopStartup($request);
        Zend_Loader::LoadClass('Gonium_Controller_Action_Helper_LoadModel');

        $module = $this->getRequest()->getModuleName();

		//////////////////// Configure Action Helper Paths ////////////////////
		// Add path and prefix of Controller Helpers of user Module
		Zend_Controller_Action_HelperBroker::addPath (
			'GoniumCore/Module/Frontend/' . $module . '/helpers', 
			'GoniumCore_Module_Frontend_' . ucfirst ( $module ) . '_Helper_'
			);
		Zend_Controller_Action_HelperBroker::addPath (
			HOME_ROOT . DS . 'Module' . DS . $module . '/helpers', 
			'Mod_'. ucfirst ( $module ) . '_Helper_'
			);
		Zend_Controller_Action_HelperBroker::addPrefix ( 'Gonium_Controller_Action_Helper' );
		
		//////////////// Configure Paths for LoadModel Helper //////////////////

		$loader = new Zend_Loader_PluginLoader ( array (), 'model' );
		$loader->addPrefixPath ( 'GoniumCore_Model_', APP_ROOT . '/Model/' )
			   ->addPrefixPath ( 'Mod_' . ucfirst ( $module ) . '_Model_', HOME_ROOT . '/Module/' . $module . '/models' );
		
		Gonium_Controller_Action_Helper_LoadModel::setLoader ( $loader );
    }

}