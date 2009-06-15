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
 * @subpackage  Init
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */


/** @see Core_Init_Abstract */
require_once 'Core/Init/Abstract.php';

/**
 * Generic Inilializer
 *
 * @package     Bootstrap
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 */
class Core_Init_Admin extends Core_Init_Abstract
{
	/**
	 * Show any PHP error in Backend
     */
    public function preInit()
    {
        error_reporting( E_ALL | E_STRICT );
    }
	
    public function postInit()
    {
        $layout = Zend_Layout::getMvcInstance();
        $layout->setView( Zend_Registry::get('core_view') );
        $layout->setLayoutPath(APP_ROOT . '/themes/default/layouts');
        $layout->setLayout('admin');
    }
    /**
     * Initialize Backend Plugins
     */
    public function initPlugins()
    {
    	$frontController = Core::getFrontController();

        // Don't change the order of core Controller Plugins
        $plugins = array(
            'Core_Init_Plugin_Backend_View' => null,
            'Core_Init_Plugin_Language' => null,
            'Core_Init_Plugin_User' => null,
            //'Init_Plugin_Frontend_Module' => null,
            //'Init_Plugin_Backend_Module' => null,
            'Core_Init_Plugin_Backend_Action' => null,
            'Core_Init_Plugin_Widget' => null
        );

        foreach($plugins as $plugin => $args)
        {
            Zend_Loader::loadClass($plugin);
            $frontController->registerPlugin( new $plugin($args) );
        }
    }
    
    /**
     * Initialize Backend Routes 
     */
    public function initRoutes()
    {
        $frontController = Core::getFrontController();
        $config = Core::getConfig();
        $router = $frontController->getRouter();
        Zend_Registry::set('core_router', $router);

        
        require_once 'Zend/Controller/Router/Route/Module.php';
        $dispatcher = Core::getFrontController()->getDispatcher();
        $request = Core::getFrontController()->getRequest();
        $compat = new Zend_Controller_Router_Route_Module(array(), $dispatcher, $request);
        //$router->removeDefaultRoutes();
        $router->addRoute('default', $compat);

		Zend_Loader::loadClass('Zend_Controller_Request_Http');
        $request = new Zend_Controller_Request_Http();
        $frontController->setRequest($request);
        
        $frontController->setBaseUrl( $request->getBaseUrl(). $config->system->backendBaseUrl );

        try {
            // Config Module Directories
            // Use section [admin] of etc/router.ini
            $config = new Zend_Config_Ini( APP_ROOT . 'etc/router.ini', 'admin');
            $router->addConfig($config);

            $config = new Zend_Config_Ini( APP_ROOT . 'etc/directories.ini', 'admin');
            // Config Module Directories
            // Use section [admin] of etc/directories.ini
            {
                foreach($config as $modules)
                {
                    $frontController->addModuleDirectory( APP_ROOT . $modules );
                }
            }
        } catch (Exception $exception) {
			/** @see Gonium_Base */
			require_once 'Gonium/Base.php';
            Gonium_Base::dumpException($exception);
        }

        return $router;
    }
}
