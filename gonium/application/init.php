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
if( !defined('GONIUM_INIT') )
/** GONIUM_INIT */
define ('GONIUM_INIT', true );

// Define some util Constants
if( !defined('CLASS_SEPARATOR') )
/** CLASS_SEPARATOR */
define ('CLASS_SEPARATOR', '_');

if( !defined('DS') )
    /** DS */
    define ('DS', DIRECTORY_SEPARATOR );

if( !defined('PS') )
    /** DS */
    define ('PS', PATH_SEPARATOR );

if( !defined('CS') )
    /** CS */
    define ('CS', CLASS_SEPARATOR);

if( !defined('APP_ROOT') )
    /** APP_ROOT */
    define ('APP_ROOT', realpath(dirname(__FILE__)) );

if( !defined('LIB_ROOT') )
    /** LIB_ROOT */
    define ('LIB_ROOT', realpath(dirname(__FILE__).DS.'..'.DS.'library') );

if( !defined('PUBLIC_ROOT') )
    /** PUBLIC_ROOT */
    define ('PUBLIC_ROOT', APP_ROOT );

if( !defined('HOME_ROOT') )
    /** APP_ROOT */
    define ('HOME_ROOT', PUBLIC_ROOT );

// Set new include_path
set_include_path('.'
	. PS . LIB_ROOT .DS
	. PS . APP_ROOT .DS
	//. PS . APP_ROOT .DS. 'Core' .DS
	. PS . HOME_ROOT .DS
	. PS . get_include_path()
    );

// Magic Quotes GPC workaround
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    function stripslashes_deep($value)
    {
        $value = is_array($value) ?
                    array_map('stripslashes_deep', $value) :
                    stripslashes($value);

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

if(!file_exists( HOME_ROOT . '/etc/config.ini' ))
{
	Zend_Registry::set(
		'GoniumCore_Config', 
		new Zend_Config_Ini(APP_ROOT . '/etc/installer.ini', APP_ENV)
	);

	// Create application
	$application = new Zend_Application(
	    'Installer', 
	    Zend_Registry::get('GoniumCore_Config')
	);
} else {
	
	Zend_Registry::set(
		'GoniumCore_Config', 
		new Zend_Config_Ini(HOME_ROOT . '/etc/config.ini', APP_ENV)
	);
	
	// Create application
	$application = new Zend_Application(
	    APP_ENV, 
	    Zend_Registry::get('GoniumCore_Config')
	);
}
	    
// Create bootstrap, and run
$application->bootstrap();
$application->run();
unset($application);