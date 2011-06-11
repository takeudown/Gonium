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
 * @package     GoniumCore_Module_Error
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Controller_Action_Helper_Error_Interface */
require_once 'Gonium/Controller/Action/Helper/Error/Interface.php';

/**
 * @package     GoniumCore_Module_Error
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Error_IndexController extends Zend_Controller_Action
{
    public function init ()
    {
        $layout = Zend_Layout::getMvcInstance();
        if (Core::getEnvironment() !== 'admin') $layout->setLayout('error');
        else
            $layout->setLayout('error_backend');
        
        $this->language = Zend_Registry::get('Zend_Translate');
        
        $this->_helper->viewRenderer->setNoRender(true);
    }
    
    public function indexAction ()
    {
        return $this->_error403();
    }
    
    public function errorAction ()
    {
        //$config = Zend_Registry::get('GoniumCore_Config');
        $errors = $this->_getParam('error_handler');
        $errorType = $errors->type;
        
        if (! is_null($errors))
        {
            $exception = $errors->exception;
            $this->_request->setParam('exception', $exception);
        } else
        {
            //$exception = $this->_request->getParam( 'exception' );
        }
        
        switch ($errorType)
        {
            // 404 error -- controller or action not found
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->_error404();
                break;
            default:
                $this->_exceptionHandle();
                break;
        }
    }
    
    /**
     * !@todo: map Exception's to Action Method
     */
    protected function _exceptionHandle (Exception $e)
    {
        try
        {
            $this->getResponse()->setRawHeader(
            'HTTP/1.1 500 Internal Server Error');
            
            try
            {
                $exception = $this->_request->getParam('exception');
                $class = new ReflectionObject($exception);
                $name = $class->getName();
                //$name = str_replace('_','',$name).'Controller';
                $name = str_replace('_', '', $name);
                $path = APP_ROOT . '/GoniumCore/Module/Error/helper/';
                
                $this->_helper->addPath($path, 'Error_Helper_');
                
                $helper = $this->_helper->{$name};
                if ($helper instanceof Gonium_Controller_Action_Helper_Error_Interface)
                {
                    
                    $this->_errorMessage($helper->getTitle(), 
                    $helper->getBody());
                
                }
            
            } catch (Exception $e)
            {
                Gonium_Exception::null($e);
                $this->_error500();
            }
        } catch (Exception $e)
        {
            Gonium_Exception::null($e);
            $this->_error500();
        }
    }
    
    public function deniedAction ()
    {
        $this->_error403();
    }
    
    public function remoteAction ()
    {
        try
        {
            $this->getResponse()->setRawHeader(
            'HTTP/1.1 500 Internal Server Error');
        } catch (Exception $e)
        {
            Gonium_Exception::null($e);
        }
        
        $this->_errorMessage($this->language->translate('Remote Error'), 
        $this->language->translate('Remote Error Message'));
    }
    
    // PROTECTED METHODS
    

    protected function _error403 ()
    {
        try
        {
            $this->getResponse()->setRawHeader('HTTP/1.1 403 Forbidden');
        } catch (Exception $e)
        {
            Gonium_Exception::null($e);
        }
        
        $this->_errorMessage('Error 403', 
        $this->language->translate('Error 403'));
    }
    
    protected function _error404 ()
    {
        try
        {
            $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
        } catch (Exception $e)
        {
            Gonium_Exception::null($e);
        }
        
        $this->view->headMeta()->appendHttpEquiv('Refresh', 
        '3;' . $this->view->url(array(), null, true));
        
        $this->_errorMessage('Error 404', 
        $this->language->translate('Error 404'));
    }
    
    protected function _error500 ()
    {
        $this->_errorMessage('Error 500', 
        $this->language->translate('Error 500'));
    }
    
    public function databaseAction ()
    {
        try
        {
            $this->getResponse()->setRawHeader(
            'HTTP/1.1 500 Internal Server Error');
        } catch (Exception $e)
        {}
        
        $e = $this->_getParam('exception');
        
        if ($e instanceof Zend_Db_Adapter_Exception)
        {
            // Connection Exception
            $this->_errorMessage(
            $this->language->translate('Database Error'), 
            $this->language->translate('Database Connection Error'));
        } else
        {
            // Connection Query Exception
            $this->_errorMessage(
            $this->language->translate('Database Error'), 
            $this->language->translate('Database Execution Error'));
        }
    }
    
    // SET ERROR MESSAGE
    protected function _errorMessage ($title, $message)
    {
        $config = Zend_Registry::get('GoniumCore_Config');
        $e = $this->_getParam('exception');
        
        $this->view->assign('errorMessage', $message);
        
        if ($config->show->errors)
        {
            $this->view->assign('errorLog', ((bool) $e) ? nl2br($e) : null);
        }
        $this->view->headTitle($title, 
        Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
    }
}
