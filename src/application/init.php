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
 * This is a procedural script to bootstrap the application.
 *
 * @category    Gonium
 * @package     Bootstrap
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

// Output Buffering
//ob_start();
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('America/Santiago');

// Define GONIUM_INIT
if (! defined('GONIUM_INIT')) /** GONIUM_INIT */
define('GONIUM_INIT', true);

// Define some util Constants
if (! defined('CLASS_SEPARATOR')) /** CLASS_SEPARATOR */
define('CLASS_SEPARATOR', '_');

if (! defined('DS')) /** DS */
define('DS', DIRECTORY_SEPARATOR);

if (! defined('PS')) /** DS */
define('PS', PATH_SEPARATOR);

if (! defined('CS')) /** CS */
define('CS', CLASS_SEPARATOR);

if (! defined('APP_ROOT')) /** APP_ROOT */
define('APP_ROOT', realpath(dirname(__FILE__)));

if (! defined('LIB_ROOT')) /** LIB_ROOT */
define('LIB_ROOT', realpath(dirname(__FILE__) . DS . '..' . DS . 'library'));

if (! defined('PUBLIC_ROOT')) /** PUBLIC_ROOT */
define('PUBLIC_ROOT', APP_ROOT);

if (! defined('HOME_ROOT')) /** APP_ROOT */
define('HOME_ROOT', PUBLIC_ROOT);

// Set new include_path
set_include_path(
    '.' . PS . LIB_ROOT . DS . PS . APP_ROOT . DS . PS . HOME_ROOT . DS . PS .
     HOME_ROOT . DS . 'library' . DS . PS . get_include_path());

// Magic Quotes GPC workaround
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{

    function stripslashes_deep ($value)
    {
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes(
            $value);
        
        return $value;
    }
    
    $_POST = array_map('stripslashes_deep', $_POST);
    $_GET = array_map('stripslashes_deep', $_GET);
    $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
    $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

/** Zend_Application */
require_once 'Zend/Application.php';
require_once 'Zend/Loader.php';
require_once 'Zend/Loader/Autoloader.php';
require_once 'Zend/Version.php';
require_once 'Gonium/Version.php';

Zend_Loader_Autoloader::getInstance()->registerNamespace('GoniumCore_');

/** Config per home */

if (! file_exists(HOME_ROOT . '/etc/config.ini'))
{
    $conf = new Zend_Config_Ini(APP_ROOT . '/etc/installer.ini', APP_ENV);
} else
{
    
    $conf = new Zend_Config_Ini(APP_ROOT . '/etc/resources.ini', APP_ENV, 
    array('allowModifications' => true));
    
    $conf->merge(new Zend_Config_Ini(HOME_ROOT . '/etc/config.ini', APP_ENV));
    $conf->setReadOnly();
}

Zend_Registry::set('GoniumCore_Config', $conf);

// Create application
$application = new Zend_Application(APP_ENV, 
Zend_Registry::get('GoniumCore_Config'));

if (APP_ENV == 'development')
{
    /*
    require_once('Zend/Log.php');
    require_once('Zend/Log/Writer/Firebug.php');
    //require_once('Zend/Controller/Response/Http.php');
    //require_once('Zend/Controller/Request/Http.php');

    // create the logger and log writer
    $writer = new Zend_Log_Writer_Firebug();
    $logger = new Zend_Log($writer);
	
	
    // get the wildfire channel
    $channel = Zend_Wildfire_Channel_HttpHeaders::getInstance();

    // create and set the HTTP response
    $response = new Zend_Controller_Response_Http();
    $channel->setResponse($response);

    // create and set the HTTP request
    $channel->setRequest(new Zend_Controller_Request_Http());

    // record log messages
    $logger->info('asdf');
    //$logger->warn('warning message');
    //$logger->err('error message');

    // insert the wildfire headers into the HTTP response
    $channel->flush();

    // send the HTTP response headers
    $response->sendHeaders();
	

	Zend_Registry::set('GoniumCore_Logger',$logger);
	*/
}

// Create bootstrap, and run
$application->bootstrap();
$application->run();
unset($conf);
unset($application);