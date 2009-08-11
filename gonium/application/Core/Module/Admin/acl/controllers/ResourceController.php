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
 * @package   Core_Module_Admin
 * @subpackage  Core_Module_Admin_Default
 * @author    {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version   $Id: IndexController.php 22 2009-06-19 16:28:36Z gnzsquall $
 */

/**
 * @package   Core_Module_Admin
 * @subpackage  Core_Module_Admin_Default
 * @author    {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version   $Id: IndexController.php 22 2009-06-19 16:28:36Z gnzsquall $
 */
class Acl_ResourceController extends Zend_Controller_Action
{
  public function indexAction()
  {
    $this->listAction();
  }
  
  public function listAction()
  {
    $lang = Zend_Registry::get('Zend_Translate');
    $this->view->bodyTitle = '<h1>Admin Permission</h1>';

    // Title of Module
    $this->view->headTitle(
      $lang->translate('Permission\'s Management'),
      Zend_View_Helper_Placeholder_Container_Abstract::PREPEND
    );

    // Create datagrid
    Zend_Loader::loadClass('Gonium_DataGrid');
    Zend_Loader::loadClass('Gonium_DataGrid_DataSource_Table');
    Zend_Loader::loadClass('Gonium_DataGrid_Pager');
    
    /*
    $grid = new Gonium_DataGrid(new Gonium_DataGrid_DataSource_Table(
      $this->_helper->LoadModel('ACL_Resource'))
    , 5);
    */
    
    Zend_Loader::loadClass('Gonium_DataGrid_DataSource_DbSelect');
    $grid = new Gonium_DataGrid(new Gonium_DataGrid_DataSource_DbSelect() , 5);
    
    $grid->getSelect()->from('gonium_view_resource_parents');
    
    // Setting default datagrid values
    $grid->setDefaultSort('resource_id')
       ->setDefaultDir("asc");
    // Translate
    $grid->getPager()->translate($lang);
    
    $grid->addColumn('resource_id', array(
        'type' => 'text',
        'header' => $lang->translate('acl_resource_id'),
        'width' => 10
      ));
    
    $grid->addColumn('parent_name', array(
        'type' => 'text',
        'header' => $lang->translate('acl_resource_parent_name'),
    'width' => 120
      ));
      
    $grid->addColumn('resource_name', array(
        'type' => 'text',
        'header' => $lang->translate('acl_resource_name')
      ));
    
    $url = (string) $this->view->url(array(
      'module'=> $this->getRequest()->getModuleName() ,
      'controller' => $this->getRequest()->getControllerName(),
      'action' => 'edit',
      'id' => '$resource_id'
    ));
    $grid->addColumn('edit', array(
      'header' => $lang->translate('Edit'),
      'width' => 10,
      'style' => 'text-align: center',
      'sortable'  => false,
      'type' => 'action',
      'actions' => array('url' => urldecode($url),
      'caption' => 'Edit',
      'image' => $this->view->baseUrl() . '../images/icons/edit_24x24.png')
    ));
    
    $url = (string) $this->view->url(array(
      'module'=> $this->getRequest()->getModuleName() ,
      'controller' => $this->getRequest()->getControllerName(),
      'action' => 'delete',
      'id' => '$resource_id'
    ));
    $grid->addColumn('delete', array(
      'header' => $lang->translate('Delete'),
      'width' => 10,
      'style' => 'text-align: center',
      'sortable' => false,
      'type' => 'action',
      'actions' => array('url' => urldecode($url),
      'confirm' => 'Are you sure you want to delete $resource_name ($resource_id)?',
      'caption' => 'Delete',
      'image' => $this->view->baseUrl() . '../images/icons/delete_24x24.png')
    ));
   
    $this->view->grid = $grid;
    
    // ACL!?
//     $resources = $this->_helper->LoadModel('ACL_Resource');
//     
//   $acl = new Gonium_ACL();
// 
//   $modules = Gonium_Controller_Action_Helper_LoadModel::getModel('ACL_Resource');
//   $modules->setIterable(true);
// 
//   $acl->loadResources($modules->getResources( array('b', 'f') ), Gonium_ACL::ORPHAN_RESOURCE_ADD);
// 
//   var_dump($acl);
  }
}
