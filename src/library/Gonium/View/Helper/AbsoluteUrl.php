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
 * @package     Gonium_View
 * @subpackage  Gonium_View_Helper
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: LoadModel.php 45 2010-03-30 07:21:30Z gnzsquall $
 */

/**
 * @package     Gonium_View
 * @subpackage  Gonium_View_Helper
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 * @deprecated	Zend_Loader_PluginLoader has the same functionality
 */
class Gonium_View_Helper_AbsoluteUrl extends Zend_View_Helper_BaseUrl
{

    /**
     * Returns site's base url, or file with base url prepended
     *
     * $file is appended to the base url for simplicity
     *
     * @param  string|null $file
     * @return string
     */
    public function absoluteUrl ($file = null)
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://';
        
        $parts = parse_url(
            $protocol . $_SERVER['HTTP_HOST'] . $this->baseUrl($file));
        // use port if non default
        $port = isset($parts['port']) && (($protocol === 'http://' &&
         $parts['port'] !== 80) ||
         ($protocol === 'https://' && $parts['port'] !== 443)) ? ':' .
         $parts['port'] : '';
        
        return $protocol . $parts['host'] . $port . $parts['path'];
    }

}