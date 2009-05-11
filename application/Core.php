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
 * @category    Gonium
 * @package     Bootstrap
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

// FRONT CONTROLLER
/** Zend_Controller_Front */
require_once 'Zend/Controller/Front.php';
/** Zend_Controller_Router_Rewrite */
require_once 'Zend/Controller/Router/Rewrite.php';
/** Zend_Controller_Response_Http */
require_once 'Zend/Controller/Response/Http.php';

/**
 * Gonium Application Bootstrap
 *
 * This is the main entry point for program implementation,
 * like C++/C#/Java main() method.
 *
 * @category    Gonium
 * @package     Bootstrap
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
final class Core
{
    /**#@+
     * Application data
     */
    /** Application Name */
    const APP = 'Gonium';
    /** Version of Application */
    const VERSION = '0.1';
    /** Last revision from SVN */
    const REVISION = '$LastChangedRevision$';
    /**#@-*/

    /**#@+
     * Default Module/Controller/Action
     */
    const DEFAULT_MODULE = 'default';
    const DEFAULT_CONTROLLER = 'index';
    const DEFAULT_ACTION = 'index';
    /**#@-*/

    /**#@+
     * Default Error Handler Module/Controller/Action
     */
    const ERROR_MODULE = 'error';
    const ERROR_CONTROLLER = 'index';
    const ERROR_ACTION = 'error';
    /**#@-*/

    /**
    * Singleton instance
    * @var Core
    */
    private static $_instance;

    /**
    * Core application has been Booted?
    * @var boolean
    */
    private static $_boot = false;

    /**
    * The environment state of your current application
    * @var string
    */
    protected static $_environment;

    /**
    * Configuration
    * @var Zend_Config
    */
    protected static $_config;

    protected static $_request;

    /**
     * Prevents the creation of new instances
     */
    private function __construct() { }

    /**
     * Prevents the copy creation of the instance
     */
    public function __clone()
    {
       throw new Exception('Clone unavailable');
    }

    public static function getInstance($environment = 'development')
    {
       if (!isset(self::$instance))
       {
          $c = __CLASS__;
          self::$_instance = new $c;
          self::$_instance->setEnvironment($environment);
       }
       return self::$_instance;
    }

    public static function isBooted()
    {
        if(self::$_boot) {
            throw new Exception( _('Bootstrap can be used only one time.') );
        }
    }

    /**
     * Convenience method to bootstrap the application
     *
     * @return mixed
     */
    public static function main()
    {
        self::isBooted();
        self::$_boot = true;

        if (!self::$_environment) {
            self::setEnvironment('development');
            /*
            throw new Exception(
                _('Please set the environment using ::setEnvironment')
            );
            */
        }

        //Zend_Loader::registerAutoload();
        Zend_Loader::loadClass('Zend_Registry');

        $frontController = self::getFrontController();
        if(!self::configure())
            self::setEnvironment('Install');
        self::initialize();
        self::dispatch($frontController);
    }

    // INFO METHODS
    /**
     * Get the Application name
     * @var String
     */
    public static function getAppName()
    {
        return self::APP;
    }

    /**
     * Get version number identifier of Application
     * @var String
     */
    public static function getVersion()
    {
        return self::VERSION;
    }

    /**
    * Get application root directory
    * @var String
    */
    public static function getRoot()
    {
        return APP_ROOT;
    }

    /**
    * Get an array with default module+controller+action for Error Handler
    * @var Array
    */
    public static function getDefaultErrorHandler()
    {
        return array(
            'module'     => self::ERROR_MODULE,
            'controller' => self::ERROR_CONTROLLER,
            'action'     => self::ERROR_ACTION
        );
    }

    /**
    * Get an array with default module+controller+action for "Index"
    * @var Array
    */
    public static function getDefaulModule()
    {
        return array(
            'module'     => self::DEFAULT_MODULE,
            'controller' => self::DEFAULT_CONTROLLER,
            'action'     => self::DEFAULT_ACTION
        );
    }

    /**
    * Sets the environment to load from configuration file
    *
    * @param string $environment - The environment to set
    * @return Core
    */
    public static function setEnvironment($environment)
    {
       self::$_environment = $environment;
       //return $this;
    }

    /**
     * Returns the environment which is currently set
     *
     * @return string
     */
    public static function getEnvironment()
    {
        return self::$_environment;
    }

    /**
     * Set the Core Configuration
     * @param Zend_Config
     */
    public static static function setConfig(Zend_Config $config)
    {
        self::$_config = $config;
    }

    /**
     * Returns the Core configuration
     *
     * @return Zend_Config
     */
    public static static function getConfig()
    {
        return self::$_config;
    }

    // MVC Methods
    /**
     * Set request class/object
     *
     * Set the request object. The request holds the request environment.
     *
     * @param Zend_Controller_Request_Abstract $request
     * @throws Zend_Controller_Exception if invalid request class
     */
    public static function setRequest(Zend_Controller_Request_Abstract $request)
    {
        self::$_request = $request;
    }

    /**
     * Get the request object.
     *
     * @return null|Zend_Controller_Request_Abstract
     */
    public static function getRequest()
    {
        if(null === self::$_request){
            self::$_request = self::getFrontController()->getRequest();
        }
        return self::$_request;
    }

    /**
     * Retorna el response object.
     *
     * @return null|Zend_Controller_Response_Abstract
     */
    public static function getResponse()
    {
        return self::getFrontController()->getResponse();
    }

    /**
     * Retorna el front controller object.
     *
     * @return null|Zend_Controller_Front
     */
    public static function getFrontController()
    {
        return Zend_Controller_Front::getInstance();
    }

    /**
     * Retorna la instancia unica del Registry
     *
     * @return Zend_Registry
     */
    public static function getRegistry()
    {
        Zend_Loader::loadClass('Zend_Registry');
        return Zend_Registry::getInstance();
    }

    /**
     * Retorna la instancia unica del Layout
     *
     * @return Zend_Layout
     */
    public static function getLayout()
    {
        Zend_Loader::loadClass('Zend_Layout');
        return Zend_Layout::getMvcInstance();
    }

    // INITIALIZATION METHODS
    private static function configure()
    {
        Zend_Loader::loadClass('Zend_Config_Ini');
        Zend_Loader::loadClass('Zend_Config_Exception');

        $frontController = self::getFrontController();

        // In development environment, display all errors
        if(self::getEnvironment() == 'development')
        {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_startup_errors', 1);
            ini_set('display_errors', 1);
        }

        $coreConfigFile = APP_ROOT . 'etc/config.ini';
        $sessionConfigFile = APP_ROOT . 'etc/session.ini';

        if( !file_exists($coreConfigFile) )
           return false;
        if( !file_exists( $sessionConfigFile) )
           return false;

        // Load the given stage from our configuration file,
        // and store it into the registry for later usage.
        try {
            $coreConfig = new Zend_Config_Ini(
                $coreConfigFile, self::getEnvironment()
            );

            // Configure
            $frontController->throwExceptions($coreConfig->show->exceptions);
            
            // Store configuration
            self::setConfig($coreConfig);
            Zend_Registry::set('core_config', $coreConfig);

            // Session Configuration
            $sessionConfig = new Zend_Config_Ini( $sessionConfigFile );

            // Configure Session
            Zend_Loader::loadClass('Zend_Session');
            Zend_Session::setOptions($sessionConfig->toArray());

            return true;

        } catch (Exception $e) {
			/** @see Rox_Base */
            require_once 'Rox/Base.php';
            Rox_Base::null($e);
            //Rox_Base::dumpException($e);
            return false;
        }

        return false;
    }

    /**
     * Initialization stage
     *
     * @return void
     */
    private static function initialize()
    {
        try {
            // Initialize
            $initializer = 'Init_'.ucfirst(self::getEnvironment());
            Zend_Loader::loadClass( $initializer );
            $initializer = new $initializer;

            $initializer->preInit();

            // Set Error Handler
            $frontController = Core::getFrontController();
            $frontController->addControllerDirectory( APP_ROOT . 'Core/Module/Error', 'error');

            //$frontController->setParam('noErrorHandler', true);
            Zend_Loader::loadClass('Rox_Controller_Plugin_ErrorHandler');
            $frontController->registerPlugin(
                new Rox_Controller_Plugin_ErrorHandler(
                    self::getDefaultErrorHandler()
                )
                ,1000
            );

            Zend_Registry::set('core_router', $frontController->getRouter());

            $initializer->initRoutes();
            $initializer->initView();
            $initializer->initDB();
            $initializer->initHelpers();
            $initializer->initPlugins();

            // Initialise Zend_Layout's MVC helpers
            Core::getLayout();
            Zend_Loader::loadClass('Rox_Controller_Plugin_Layout');
            Zend_Layout::startMvc(array(
               'pluginClass' => 'Rox_Controller_Plugin_Layout'
            ));

            $initializer->postInit();

        } catch(Exception $e) {
			/** @see Rox_Base */
			require_once 'Rox/Base.php';
            Rox_Base::dumpException($e);
        }
    }

    /**
     * Dispatches the request
     *
     * @param  object Zend_Controller_Front $frontController - The frontcontroller
     * @return object Zend_Controller_Response_Abstract
     */
    private static function dispatch()
    {
        Zend_Loader::loadClass('Zend_Controller_Response_Http');
        $frontController = self::getFrontController();
        $frontController->setResponse(new Zend_Controller_Response_Http() );

        try {
            $response = $frontController->dispatch();
        } catch (Exception $exception) {
			/** @see Rox_Base */
			require_once 'Rox/Base.php';
            Rox_Base::dumpException($exception);

            $response = $frontController->getResponse();
        }

        return $response;
    }

    /**
     * Renders the response
     *
     * @param  object Zend_Controller_Response_Abstract $response - The response object
     * @return void
     */
    private static function render(Zend_Controller_Response_Abstract $response)
    {
        /*
        if( !$response->isException() )
             $response->sendHeaders();
        */

        $response->outputBody();

        //$response->sendResponse();
    }
}
