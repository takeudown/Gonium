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
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Define home files base directory */
define('HOME_ROOT', realpath(dirname(__FILE__)));
/** Define public files base directory */
define('PUBLIC_ROOT', realpath(dirname(__FILE__) . '/public_html/'));
/** Define application base directory */
defined('APP_ROOT') || define('APP_ROOT', 
(getenv('GONIUM_APP_ROOT') ? getenv('GONIUM_APP_ROOT') : realpath(
dirname(__FILE__) . '/../application/')));

/** Define application environment */
defined('APP_ENV') ||
 define('APP_ENV', (getenv('APP_ENV') ? getenv('APP_ENV') : 'development'));

// Save current working directory
$cwd = getcwd();
// Set new current working directory to /application
chdir(APP_ROOT);

/**
 * Common Procedural Initialization
 * Boot the application 
 */
require_once APP_ROOT . '/init.php';

// Restore working directory
chdir($cwd);
unset($cwd);
