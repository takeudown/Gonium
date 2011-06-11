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
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: View.php 47 2010-04-01 16:04:03Z gnzsquall $
 */

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Configure View scripts and View Helper paths
 *
 * @package     Bootstrap
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: View.php 47 2010-04-01 16:04:03Z gnzsquall $
 */
class GoniumCore_Plugin_Admin_View extends Zend_Controller_Plugin_Abstract
{

    public $config;

    public $view;
    
    public function dispatchLoopStartup (
    Zend_Controller_Request_Abstract $request)
    {
        parent::dispatchLoopStartup($request);
        $this->config = Zend_Registry::get('GoniumCore_Config');
        $this->view = Zend_Registry::get('GoniumCore_View');
        
        $this->view->getHelper('BaseUrl')->setBaseUrl(
        $this->config->page->baseUrl);
    }
}