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
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Define public files base directory */
define('PUBLIC_ROOT', dirname(__FILE__));

/** Common Procedural Initialization */
require_once '../application/init.php';

// Save current working directory
$cwd = getcwd();
// Set new current working directory to /application
chdir( APP_ROOT );

/** @see Core */
require_once 'Core.php';

/**
 * Setting 'development' environment explicity
 */
Core::setEnvironment('development');

/**
 * Boot the application (only once)
 * Initialize on 'development' environment by default
 */
Core::main();

// Restore working directory
chdir( $cwd );
unset( $cwd );

