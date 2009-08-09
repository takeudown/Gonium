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
 * @package     Rox
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/**
 * Provide common static functionalities
 * 
 * @category    Gonium
 * @package     Bootstrap
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 * @deprecated	Methods moved to Gonium_Exception
 */
class Gonium_Base
{
    public static function dumpException(Exception $exception)
    {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html><head><title>Oops!</title></head>'
                . '<body><center>'
                . 'An exception occured while bootstrapping the application.';
        echo '<br /><br />' . $exception->getMessage() . '<br />'
                . '<div align="left">Stack Trace:'
                . '<pre>' . $exception->getTraceAsString() . '</pre></div>';
        echo '</center></body></html>';
        exit(1);
    }

    /**
     * To acomplish stric standars, this method does nothing with the param.
     * Simply, return the same entered value.
     *  
     * @param mixed 
     * @return mixed
     */
    public static function null($var)
    {
        return $var;
    }
}