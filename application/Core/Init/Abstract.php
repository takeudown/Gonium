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
 * @version     $Id: Abstract.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/**
 * Generic Inilializer
 *
 * @package     Bootstrap
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 */
abstract class Init_Abstract
{
    public function preInit() {}

    /**
     * @todo Quitar de aca la configuracion del Layout, deberia obtener
     * el tema desde la base de datos.
     */
    public function postInit() {
        $layout = Zend_Layout::getMvcInstance();
        $layout->setView( Zend_Registry::get('core_view') );
        $layout->setLayoutPath(APP_ROOT . '/themes/default/layouts');
        $layout->setLayout('frontend');
    }

    /**
	 * Initialize Controller Helpers
     */
    public function initHelpers()
    {
        Zend_Loader::loadClass('Zend_Controller_Action_HelperBroker');

        Zend_Controller_Action_HelperBroker::addPrefix(
            'Rox_Controller_Action_Helper'
        );
    }

    /**
     * Initialize View Layer
     */
    public function initView() {
        Zend_Loader::loadClass('Zend_View');
        Zend_Registry::set('core_view', new Zend_View());
    }

    /**
     * Initialize Database and Model Layer
     */
    public function initDb()
    {
        Zend_Loader::loadClass('Zend_Db');
        Zend_Loader::loadClass('Rox_Db_Table_Abstract');

        $config = Core::getConfig();

        if( $config === null
            || !isset($config->database)
            || !isset($config->database->adapter)
            || !isset($config->database->prefix)
            || !isset($config->database->params)
            || !isset($config->database->params->host)
            || !isset($config->database->params->username)
            || !isset($config->database->params->password)
            || !isset($config->database->params->dbname)
          )
        {
            include( APP_ROOT . 'install.html' );
            die('database configuration error');
        }

        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        Zend_Registry::set('core_db', $db );

        $config = Zend_Registry::get('core_config');
        $db = Zend_Registry::get('core_db');
        $db->getConnection();

        // Table Prefix
        Zend_Loader::loadClass('Rox_Db_Table_Abstract');
        Rox_Db_Table_Abstract::setPrefix( $config->database->prefix );

        // Set charset
        if( isset($config->database->charset) && $config->database->charset !== null )
        {
            switch( $config->database->adapter )
            {
                case 'mysqli':
                case 'pdo_mysql':
                    $db->query('SET NAMES \''.strtoupper($config->database->charset).'\'');
                    $db->query('SET CHARACTER SET '.strtoupper($config->database->charset));
                    break;
            }
        }
    }

    /**
     * Load and Register Basic Plugins
     *
     * @return OpenModular
     * @param $frontController Object
     */
    public function initPlugins()
    {
        $frontController = Core::getFrontController();

        // Don't change the order of core Controller Plugins
        $plugins = array(
            'Init_Plugin_View' => null,
            'Init_Plugin_Language' => null,
            'Init_Plugin_User' => null,
            'Init_Plugin_Frontend_Module' => null,
            'Init_Plugin_Frontend_Action' => null,
            'Init_Plugin_Widget' => null
        );

        foreach($plugins as $plugin => $args)
        {
            Zend_Loader::loadClass($plugin);
            $frontController->registerPlugin( new $plugin($args) );
        }
    }

    /**
     * Sets up the custom routes
     *
     * @param  object Zend_Controller_Front $frontController - The frontcontroller
     * @return object Zend_Controller_Router_Rewrite
     */
    public function initRoutes()
    {
        $frontController = Core::getFrontController();
        $router = $frontController->getRouter();
        Zend_Registry::set('core_router', $router);

        try {
            // Config Routes
            // Use section [frontend] of etc/router.ini
            $config = new Zend_Config_Ini( APP_ROOT . 'etc/router.ini', 'frontend');
            $router->addConfig($config);

            // Config Module Directories
            // Use section [frontend] of etc/router.ini
            $config = new Zend_Config_Ini( APP_ROOT . 'etc/directories.ini', 'frontend');
            {
                foreach($config as $modules)
                {
                    $frontController->addModuleDirectory( APP_ROOT . $modules );
                }
            }

        } catch (Exception $exception) {
			/** @see Rox_Base */
			require_once 'Rox/Base.php';
            Rox_Base::dumpException($exception);
        }
        return $router;
    }
}
