<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 * Copyright (C) 2008 Gonzalo Diaz Cruz
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
 * @version     $Id: View.php 47 2010-04-01 16:04:03Z gnzsquall $
 */

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Configure Routes
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: View.php 47 2010-04-01 16:04:03Z gnzsquall $
 */

class GoniumCore_Plugin_Router extends Zend_Controller_Plugin_Abstract
{
    
    public function routeStartup (Zend_Controller_Request_Abstract $request)
    {
        
        $frontController = Zend_Controller_Front::getInstance();
        $router = $frontController->getRouter();
        Zend_Registry::set('GoniumCore_Router', $router);
        
        try
        {
            // Config Routes
            // Use section [frontend] of HOME_ROOT/etc/router.ini
            $config = new Zend_Config_Ini(
            HOME_ROOT . '/etc/router.ini', 'frontend');
            $router->addConfig($config);
        
        } catch (Exception $exception)
        {
            /** @see Gonium_Exception */
            require_once 'Gonium/Exception.php';
            Gonium_Exception::dump($exception);
        }
    }
}