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
 * @package   Bootstrap
 * @subpackage  Plugin_Backend
 * @author    {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version   $Id$
 */

/** @see GoniumCore_Plugin_View */
require_once 'GoniumCore/Init/Plugin/View.php';

/**
 * Configure View scripts and View Helper paths
 *
 * @package   Bootstrap
 * @subpackage  Plugin_Backend
 * @author    {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version   $Id$
 */
class GoniumCore_Plugin_Backend_View extends GoniumCore_Plugin_View
{
  public function preDispatch(Zend_Controller_Request_Abstract $request)
  {
    Zend_Controller_Plugin_Abstract::preDispatch($request);
    $module = $this->getRequest()->getModuleName();
    $config = Zend_Registry::get('GoniumCore_config');
    $view = Zend_Registry::get('GoniumCore_View');

    $view->setScriptPath(
      array(
        APP_ROOT . 'GoniumCore/Module/Admin/'.$module.'/views/scripts/',
        APP_ROOT . 'themes/default/',
        APP_ROOT . 'GoniumCore/view/',
        './',
      )
    );

    // Clear previous Helper paths
    $view->setHelperPath(null);

    // Reset Rox Libraries View Helpers
    $view->addHelperPath( 'Gonium/View/Helper/', 'Gonium_View_Helper');

    // Add View helpers path to module
    $view->addHelperPath(
      APP_ROOT . 'GoniumCore/Module/Admin/'.$module.'/views/helpers',
      ucfirst($module) . '_View_Helper'
    );
    
    // (Re)Configure new Title
    $view->headTitle()->setSeparator(' | ');
    $view->headTitle( stripslashes($config->page->title), 
      Zend_View_Helper_Placeholder_Container_Abstract::SET
    );
  }
}