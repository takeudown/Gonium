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

/** @see GoniumCore_Init_Abstract */
require_once 'GoniumCore/Init/Abstract.php';

/**
 * Installer Initializer
 *
 * @package     Bootstrap
 * @subpackage  Init
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Init_Install extends GoniumCore_Init_Abstract {

	/**
	 * Doesn't show any PHP error
     */
    public function preInit()
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('magic_quotes_gpc', false);
        Core::getFrontController()->throwExceptions(true);

        $frontController = Core::getFrontController();
        $frontController->setControllerDirectory( Core::getRootDir() . 'GoniumCore/Module/Install/controllers', 'install');
        $frontController->setDefaultModule('install');
    }

    public function postInit()
    {
        $layout = Zend_Layout::getMvcInstance();
        $layout->setView( Zend_Registry::get('GoniumCore_view') );
        $layout->setLayoutPath( Core::getRootDir() . '/themes/default/layouts');
        $layout->setLayout('install');
    }

    public function initDB()
    {
        // Nothing to do!
    }

    public function initPlugins()
    {
    $frontController = Core::getFrontController();

        // Don't change the order of core Controller Plugins
        $plugins = array(
            'GoniumCore_Init_Plugin_Install_View' => null,
            'GoniumCore_Init_Plugin_Install_Language' => null,
        );

        foreach($plugins as $plugin => $args)
        {
            Zend_Loader::loadClass($plugin);
            $frontController->registerPlugin( new $plugin($args) );
        }
    }

    public function initRoutes()
    {
        $frontController = Core::getFrontController();
        $router = $frontController->getRouter();
        Zend_Registry::set('GoniumCore_router', $router);

        return $router;
    }

    public function initView()
    {
        Zend_Loader::loadClass('Zend_View');
        Zend_Registry::set('GoniumCore_view', new Zend_View());

        $view = Zend_Registry::get('GoniumCore_view');
        // Reset Rox Libraries View Helpers
        $view->addHelperPath( 'Gonium/View/Helper/', 'Gonium_View_Helper');

        return $view;
    }
}
