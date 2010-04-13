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
 * Configure View scripts and View Helper paths
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Plugin_View extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
    	parent::dispatchLoopStartup($request);
        $config = Zend_Registry::get('GoniumCore_Config');
        $view = Zend_Registry::get('GoniumCore_View');
        
        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
        $view->setEscape('htmlentities');
        
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');

        // GLOBAL VIEW VARIABLES
        $view->assign('page_title', stripslashes($config->page->title));
        $view->assign('page_slogan', stripslashes($config->page->slogan));

        // Reset Gonium Libraries View Helpers
        $view->addHelperPath( 'Gonium/View/Helper/', 'Gonium_View_Helper');
        
        // @todo Create a mechanism to set theme url
        $view->getHelper('GlobalUrl')->setBaseUrl($config->resources->layout->globalUrl);
        $view->getHelper('ThemeUrl')->setBaseUrl($config->resources->layout->themeUrl);
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	$module = $this->getRequest()->getModuleName();
    	$config = Zend_Registry::get('GoniumCore_Config');
    	$view = Zend_Registry::get('GoniumCore_View');
    	
    	$view->currentModuleName = $request->getModuleName();
        $view->currentControllerName = $request->getControllerName();
        $view->currentActionName = $request->getActionName();
    	
    	
    	// Clear previous Helper paths
        $view->setHelperPath(null);
		
        // Reset Gonium Libraries View Helpers
        $view->addHelperPath( 'Gonium/View/Helper/', 'Gonium_View_Helper');
        
        // Add View helpers path to module
        $view->addHelperPath(
            HOME_ROOT . DS . 'Module' . DS . $module . '/views/helpers',
            ucfirst($module) . '_View_Helper'
        );
        
        // (Re)Configure new Title
        $view->headTitle()->setSeparator(' | ');
        $view->headTitle( stripslashes($config->page->title), 
            Zend_View_Helper_Placeholder_Container_Abstract::SET
        );
        
        //$view->getHelper('ModUrl')->setBaseUrl($config->resources->layout->layoutUrl);
        
        $view->setScriptPath(
            array(
                APP_ROOT  . '/view/',
                APP_ROOT  . '/GoniumCore/Module/'.$module.'/views/scripts/',
                HOME_ROOT . '/Module/'.$module.'/views/scripts',
                //	APP_ROOT  . '/themes/default/',
                './',
            )
        );
    }
}