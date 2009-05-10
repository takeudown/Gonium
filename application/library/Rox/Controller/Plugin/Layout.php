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
 * @package     Rox_Controller
 * @subpackage  Rox_Controller_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Layout.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** Zend_Layout_Controller_Plugin_Layout */
require_once 'Zend/Layout/Controller/Plugin/Layout.php';

/**
 * Render layouts
 *
 * This version of "Zend Layout Controller Plugin" moves the
 * method postDispatch towards method dispatchLoopShutdown, to run only
 * once at the end of the dispatch loop, and not several times as happens
 * with preDisptach and postDisptach hooks, when making redirects or
 * stacked several actions in the Action Stack.
 *
 * @package     Rox_Controller
 * @subpackage  Rox_Controller_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Layout.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Rox_Controller_Plugin_Layout extends Zend_Layout_Controller_Plugin_Layout
{
    /**
     * Configures the path to the view scripts of Layouts
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        parent::dispatchLoopStartup($request);
        // Set a layout script path:
        $layout = Zend_Layout::getMvcInstance();

        // If request by ajax, change the layout
        if( $this->getRequest()->isXmlHttpRequest() )
        {
            $layout = Zend_Layout::getMvcInstance();
            $layout->setLayout('ajax');
        }
    }

    /**
     * Rewrite postDispatch() plugin hook -- render layout
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request) {
        // Do nothing
        Zend_Controller_Plugin_Abstract::postDispatch($request);
    }

    /**
     * dispatchLoopShutdown() plugin hook -- render layout
     *
     * @param  Zend_Controller_Request_Abstract $request
     * @return void
     */
    public function dispatchLoopShutdown()
    {
        // Call Parent Post Dispatch
        return parent::postDispatch( $this->getRequest() );
    }
}
