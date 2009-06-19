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
 * @package     Core_Module_Error
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Form_Prepared_SiteInstaller */
require_once 'Gonium/Form/Prepared/SiteInstaller.php';

/**
 * @package     Core_Module_Error
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class IndexController extends Zend_Controller_Action
{
    private $_view;
    private $_lang;
    private $_stringConfig;
    private $_etc;

    public function init()
    {
        $this->_view = Zend_Registry::get('core_view');
        $this->_lang = Zend_Registry::get('Zend_Translate');
        $this->_etc = HOME_ROOT.'/etc/';
    }

    public function preDispatch()
    {
        $this->_view->headTitle()->setSeparator(' | ');
        $this->_view->headTitle(Core::getAppName(), Zend_View_Helper_Placeholder_Container_Abstract::SET);
    }

    public function indexAction()
    {
        $this->_view->headTitle($this->_lang->translate('Install'), Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);

        Zend_Loader::loadClass('Gonium_Form_Prepared_SiteInstaller');
        $form = new Gonium_Form_Prepared_SiteInstaller();
        $form->setAction($this->_view->url(array(
                'module' => $this->_request->getModuleName(),
                'controller' => $this->_request->getControllerName(),
                'action' => $this->_request->getActionName(),
                //'action' => 'db-connection'
            )));

        if($this->getRequest()->isPost() && $form->isValid($_POST) && $this->tryConnection($form))
        {
            /* IMPORTAR SQL */
            $this->importSQL($form);
            /****************/
            $this->configure($form);

            //$this->_forward('writeConfig');

        } else {
            $this->_view->form = $form;
        }
    }

    /**
     * Try to connect to new Database
     *
     * @return boolean
     */
    private function tryConnection(Gonium_Form_Prepared_SiteInstaller $dbForm)
    {
		Zend_loader::loadClass('Zend_Db');
        try{
            $db = Zend_Db::factory( $dbForm->dbConnection->dbadapter->getValue(), array(
                'host'             => $dbForm->dbConnection->dbhost->getValue(),
                'username'         => $dbForm->dbConnection->dbuser->getValue(),
                'password'         => $dbForm->dbConnection->dbpass->getValue(),
                'dbname'           => $dbForm->dbConnection->dbname->getValue(),
                //'adapterNamespace' => 'MyProject_Db_Adapter'
            ));

            $db->getConnection();
            Zend_Registry::set('db', $db);

            //return $this->_forward('writeConfig');
            return true;

        } catch(Exception $e) {
            $this->_view->messageError = $e->getMessage();

            //return false;
            //return $this->_forward('index');
        }

        return false;
    }

    private function importSQL(/*$form*/)
    {
        //$db = Zend_Registry::get('db');

        // Import
    }

    private function configure(Gonium_Form_Prepared_SiteInstaller $form)
    {
        $config = new Zend_Config(array(), true);

        $config->all            = array();
        $config->development    = array();
        $config->production     = array();
        $config->admin          = array();
        
        $config->setExtend('production', 'all');
        $config->setExtend('development', 'all');
        $config->setExtend('admin', 'development');

        // Page
        $config->all->page  = array(
            'title' => $form->getValue('site_name'),
            'slogan' => $form->getValue('site_slogan'),
            'environment' => 'intranet' 
        );
        
        // Database 
        $config->all->database    = array(
            'adapter'   => $form->dbConnection->getValue('dbadapter'),
            'prefix'    => $form->dbConnection->getValue('dbprefix'),
            'charset'   => 'utf8', //$form->dbConnection->getValue('dbcharset'),
            'params' => array(
                'host'      => $form->dbConnection->getValue('dbhost'),
                'username'  => $form->dbConnection->getValue('dbuser'),
                'password'  => $form->dbConnection->getValue('dbpass'),
                'dbname'    => $form->dbConnection->getValue('dbname')
        ));

        // System
        Zend_Loader::loadClass('Gonium_Crypt_Keygen');
        $keygen = new Gonium_Crypt_Keygen();
        $keygen->setLength(16);
        $keygen->setUseSigns(true);
        
        $config->all->system = array(
            'backendBaseUrl'    => '/admin/',
            'key'               => (string) $keygen
        );

        // Errors & Exceptions
        $config->all->show = array(
            'errors'        => false,  // do not show exceptions in error pages
            'exceptions'    => false,  // do not show exceptions in bootstrap
            'dbInfo'        => false   // do not show detailed database info
        ); 

        $config->development->show = array(
            'errors'        => true,  // show exceptions in error pages
            'exceptions'    => true,  // show exceptions in bootstrap
            'dbInfo'        => true   // show detailed database info
        );
        
		Zend_Loader::loadClass('Gonium_Config_Writer_Ini');
        $writer = new Gonium_Config_Writer_Ini(array(
                'config'   => $config,
                'filename' => $this->_etc.'config.ini'
            ));

        if(is_writeable($this->_etc))
        {
            /** Config Form */
            $configForm = new Gonium_Form(array(
                'elements' => array(
                    'config' => array('hidden'),
                    'submit' => array('submit', array(
                        'label' => _('Write configuration file'),
                    ))
                )
            ));

            $configForm->setAction($this->_view->url(array(
                'module' => $this->_request->getModuleName(),
                'controller' => $this->_request->getControllerName(),
                'action' => 'write-config'
            )));

        } else {

            /** Config Form */
            $configForm = new Gonium_Form(array(
                'elements' => array(
                    'config' => array('textarea'),
                    'submit' => array('submit', array(
                        'label' => _('Download configuration file'),
                    ))
                )
            ));

            $configForm->setAction($this->_view->url(array(
                'module' => $this->_request->getModuleName(),
                'controller' => $this->_request->getControllerName(),
                'action' => 'download-config'
            )));

            $this->_view->messageError = $this->_lang->translate('Error: writing file');
            $this->_view->messageSuccess = $this->_lang->translate('Download config.ini file and upload to application/etc/');
        }

        $configForm->config->setValue( $writer->build() );
        $this->_view->form = $configForm;
    }

    public function downloadConfigAction()
    {
        if($this->_request->isPost())
           $config = $this->_request->getPost('config');

        if($config !== null)
        {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();

            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=config.ini");

            echo $config;
        }
    }

    public function writeConfigAction()
    {
        if($this->_request->isPost())
           $config = $this->_request->getPost('config');

        $destFile = $this->_etc.'config.ini';

        if($config !== null && is_writeable($this->_etc) && file_put_contents($destFile, $config))
        {
            $this->_helper->viewRenderer->setScriptAction('index');
            $this->_view->messageSuccess = $this->_lang->translate('Installation success');
            $this->_view->homeLink = true;
            return true;
        } else {
            return $this->_forward('downloadConfig');
        }
    }
}
