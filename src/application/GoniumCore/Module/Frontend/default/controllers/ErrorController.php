<?php

/**
 * Error controller
 *
 * @uses       Zend_Controller_Action
 * @package    QuickStart
 * @subpackage Controller
 */
class ErrorController extends Zend_Controller_Action
{

    /**
     * errorAction() is the action that will be called by the "ErrorHandler" 
     * plugin.  When an error/exception has been encountered
     * in a ZF MVC application (assuming the ErrorHandler has not been disabled
     * in your bootstrap) - the Errorhandler will set the next dispatchable 
     * action to come here.  This is the "default" module, "error" controller, 
     * specifically, the "error" action.  These options are configurable, see 
     * {@link http://framework.zend.com/manual/en/zend.controller.plugins.html#zend.controller.plugins.standar
     *
     * @return void
     */
    public function errorAction ()
    {
        $errors = $this->_getParam('error_handler');
        $log = Zend_Registry::get('GoniumCore_Log');
        $log->err($errors->exception);
        
        switch ($errors->type)
        {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                break;
            
            default:
                // application error 
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                break;
        }
        
        $this->view->exception = $errors->exception;
        $this->view->request = $errors->request;
    }
}
