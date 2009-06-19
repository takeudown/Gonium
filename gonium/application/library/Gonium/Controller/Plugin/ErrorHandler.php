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
 * @package     Gonium_Controller
 * @subpackage  Gonium_Controller_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: ErrorHandler.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** Zend_Controller_Plugin_ErrorHandler */
require_once 'Zend/Controller/Plugin/ErrorHandler.php';

/**
 * Replace of classic Zend Framework ErrorHandler controller plugin
 *
 * @package     Gonium_Controller
 * @subpackage  Gonium_Controller_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: ErrorHandler.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Controller_Plugin_ErrorHandler extends Zend_Controller_Plugin_ErrorHandler
{
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
        parent::postDispatch($request);
        $frontController = Zend_Controller_Front::getInstance();
        $response = $this->getResponse();

        if($response->isException()) {
            foreach( $frontController->getPlugins() as $plugin )
            {
                // Don't unregister Layout Plugin, to show Error Layout
                if( !($plugin instanceof Zend_Layout_Controller_Plugin_Layout))
                    $frontController->unregisterPlugin($plugin);
            }
        }
    }
}
