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
 * @package     GoniumCore_Module_Admin
 * @subpackage  GoniumCore_Module_Admin_Default
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: IndexController.php 22 2009-06-19 16:28:36Z gnzsquall $
 */

/**
 * @package     GoniumCore_Module_Admin
 * @subpackage  GoniumCore_Module_Admin_Default
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: IndexController.php 22 2009-06-19 16:28:36Z gnzsquall $
 */
class Acl_IndexController extends Zend_Controller_Action
{
    public function indexAction ()
    {
        $this->listAction();
    }
    
    public function listAction ()
    {
        $lang = Zend_Registry::get('Zend_Translate');
        $this->view->bodyTitle = '<h1>Admin Permission</h1>';
        
        // Title of Module
        $this->view->headTitle(
        $lang->translate('Permission\'s Management'), 
        Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
        
        // Create datagrid
        Zend_Loader::loadClass('Gonium_DataGrid');
        Zend_Loader::loadClass('Gonium_DataGrid_DataSource_Table');
        Zend_Loader::loadClass('Gonium_DataGrid_Pager');
    }
}
