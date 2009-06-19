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

/**
 * @package     Core_Module_Error
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Error_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $layout = Zend_Layout::getMvcInstance();
        if(Core::getEnvironment() !== 'admin')
            $layout->setLayout('error');
        else
            $layout->setLayout('error_backend');

        $this->language = Zend_Registry::get('Zend_Translate');

        $this->_helper->viewRenderer->setNoRender(true);
    }
   
    public function indexAction()
    {
        return $this->_error403();
    }
    
    public function errorAction()
    {
        //$config = Zend_Registry::get('core_config');
        $errors = $this->_getParam('error_handler');

        if(!is_null($errors))
        {
            $error = $errors->type;
            $exception = $errors->exception;
            $this->_request->setParam( 'exception', $exception );
        } else {
            $error = null;
            $exception = $this->_request->getParam( 'exception' );
        }
        
        switch ($error)
        {
            // 404 error -- controller or action not found
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->_error404();
			break;
            default:
                //$this->_handleException($exception);
                
                if ($exception instanceof Zend_Db_Exception)
                {
                    $this->databaseAction();
                } else {
                    $this->_error500();
                }
                
            break;
        }
    }
    
    /**
    * !@todo: map Exception's to Action Method
    */
    /*
    protected function _exceptionHandle(Exception $e)
    {
        
        // Create an instance of the ReflectionClass class
        $class = new ReflectionObject($e);

        $name = $class->getName();
        var_dump($name);
        die();
    }
    */
    
    public function deniedAction()
    {
        $this->_error403();
    }
    
    public function remoteAction()
    {
        try {
            $this->getResponse()->setRawHeader('HTTP/1.1 500 Internal Server Error');
        } catch(Exception $e) { Core::null($e); }
        
        $this->_errorMessage( 
            $this->language->translate('Remote Error'),
            $this->language->translate('Remote Error Message')
        );
    }
    
    // PROTECTED METHODS
    
    protected function _error403()
    {
        try {
            $this->getResponse()->setRawHeader('HTTP/1.1 403 Forbidden');
        } catch(Exception $e) { Core::null($e); }
        
        $this->_errorMessage(
            'Error 403', 
            $this->language->translate('Error 403')
        );
    }

    protected function _error404()
    {        
        try {
            $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
        } catch(Exception $e) { Core::null($e); }
        
        $this->view->headMeta()->appendHttpEquiv(
            'Refresh', '3;'. $this->view->url( array(), null, true)
        );

        $this->_errorMessage(
            'Error 404', 
            $this->language->translate('Error 404')
        );
    }

    protected function _error500()
    {
        try {
            $this->getResponse()->setRawHeader('HTTP/1.1 500 Internal Server Error');
        } catch(Exception $e) { Core::null($e); }

        $this->_errorMessage(
            'Error 500', 
            $this->language->translate('Error 500')
        );
    }

    public function databaseAction()
    {
        try {
            $this->getResponse()->setRawHeader('HTTP/1.1 500 Internal Server Error');
        } catch(Exception $e) {}
        
        $e = $this->_getParam('exception');

        if( $e instanceof Zend_Db_Adapter_Exception )
        {
            // Connection Exception
            $this->_errorMessage( 
                $this->language->translate('Database Error'),
                $this->language->translate('Database Connection Error')
            );
        } else {        
            // Connection Query Exception
            $this->_errorMessage( 
                $this->language->translate('Database Error'),
                $this->language->translate('Database Execution Error')
            );
        }
    }
    
    // SET ERROR MESSAGE
    protected function _errorMessage($title, $message)
    {
    	$config = Zend_Registry::get('core_config');
        $e = $this->_getParam('exception');
        
        $this->view->assign( 'errorMessage', $message );
        
        if($config->show->errors)
        {
	        $this->view->assign( 'errorLog', ((bool) $e) ? nl2br($e) : null );     
        }
        $this->view->headTitle( $title,
            Zend_View_Helper_Placeholder_Container_Abstract::PREPEND
        );
    }
}
