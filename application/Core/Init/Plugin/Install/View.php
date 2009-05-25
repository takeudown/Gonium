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
 * @subpackage  Init_Plugin
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
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Init_Plugin_Install_View extends Zend_Controller_Plugin_Abstract
{
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
		Zend_Loader::loadClass('Gonium_Base');
    	Gonium_Base::null($request);

    	$view = Zend_Registry::get('core_view');

        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8');

        $view->setScriptPath(
            array(
                APP_ROOT . 'Core/Module/Install/views/scripts',
                './',
            )
        );

        // Reset Rox Libraries View Helpers
        $view->addHelperPath( 'Gonium/View/Helper/', 'Gonium_View_Helper');

        // Add View helpers path to module
        $view->addHelperPath(
            APP_ROOT . 'Core/Module/Install/views/helpers',
            'Install_View_Helper'
        );

        $helper = new Zend_Controller_Action_Helper_ViewRenderer();
        $helper->setViewScriptPathSpec(':action.:suffix');
        $helper->setViewSuffix('phtml');
        $helper->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($helper);
    }

}