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
 * @package     Core_Module_Admin
 * @subpackage  Core_Module_Admin_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $uid: IndexController.php 108 2008-11-27 01:12:14Z gnzsquall $
 */

/**
 * @package     Core_Module_Admin
 * @subpackage  Core_Module_Admin_User
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $uid: IndexController.php 108 2008-11-27 01:12:14Z gnzsquall $
 */
class User_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $lang = Zend_Registry::get('Zend_Translate');
        $this->view->bodyTitle = '<h1>Hello User Admin World!</h1>';

        // Title of Module
        $this->view->headTitle(
            $lang->translate('User\'s Management'),
            Zend_View_Helper_Placeholder_Container_Abstract::PREPEND
        );

        // Create datagrid
        $grid = new Rox_DataGrid(new Rox_DataGrid_DataSource_Table(
            $this->_helper->LoadModel('User'))
        , 5);
        // Setting default datagrid values
        $grid->setDefaultSort('username')
             ->setDefaultDir("asc");
        // Translate
        $grid->getPager()->translate($lang);
        
        $grid->addColumn('uid', array(
                'type' => 'text',
                'header' => 'Identidad',
                'width' => 10
            ));
        
        $grid->addColumn('username', array(
                'type' => 'text',
                'header' => $lang->translate('username')
            ));
        
        $url = (string) $this->view->url(array(
            'module'=> $this->getRequest()->getModuleName() ,
            'controller' => $this->getRequest()->getControllerName(),
            'action' => 'edit',
            'id' => '$uid'
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
            'id' => '$uid'
        ));
        $grid->addColumn('delete', array(
            'header' => $lang->translate('Delete'),
            'width' => 10,
            'style' => 'text-align: center',
            'sortable' => false,
            'type' => 'action',
            'actions' => array('url' => urldecode($url),
            'confirm' => 'Â¿Are you sure you want to delete $username ($uid)?',
            'caption' => 'Delete',
            'image' => $this->view->baseUrl() . '../images/icons/delete_24x24.png')
        ));
     
        $this->view->grid = $grid;
    }

    public function createAction()
    {
        $form = $this->_helper->UserForm()->createUserForm();
        $form->setAction( (string) $this->view->url( array(
                    'module'=> $this->getRequest()->getModuleName() ,
                    'controller' => $this->getRequest()->getControllerName(),
                    'action' => $this->getRequest()->getActionName(),
                ), 
                null,
                true
            ));
        $form->setMethod('post');
        
        if ( $this->getRequest()->isPost() && $form->isValid($_POST) )  {
            // Guardar datos
            //$form->removeElement('submit');
            $userModel = $this->_helper->LoadModel('User');
            $userModel->create(
                $form->username->getValue(),
                $form->password->getValue()
            );
        }
        
        $this->view->form = $form;
    }
}
