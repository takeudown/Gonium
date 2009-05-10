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
 * @subpackage  Init_Plugin_Backend
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Action.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Configure paths to Controller Action Helpers
 *
 * @package     Bootstrap
 * @subpackage  Init_Plugin_Backend
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Action.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Init_Plugin_Backend_Action extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        parent::dispatchLoopStartup($request);
        Zend_Loader::LoadClass('Rox_Controller_Action_Helper_LoadModel');

        $module = $this->getRequest()->getModuleName();

        //////////////////// Configure Action Helper Paths ////////////////////
        // Add path and prefix of Controller Helpers of user Module
        Zend_Controller_Action_HelperBroker::addPath(
            'Core/Module/Admin/'.$module.'/helpers',
            'Core_Module_Admin_'.ucfirst($module).'_Helper_'
        );

        //////////////// Configure Paths form LoadModel Helper ////////////////
        // Reset default Model path
        Rox_Controller_Action_Helper_LoadModel::resetPaths();

        // Add path and prefix of Models of user Module
        Rox_Controller_Action_Helper_LoadModel::addPath(
            'Core/Module/Admin/'.$module.'/models',
            'Core_Module_Admin_'.ucfirst($module).'_Model_'
        );
    }
}
