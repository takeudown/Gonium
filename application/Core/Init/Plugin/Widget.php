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
 * @package     Bootstrap
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Widget */
require_once 'Gonium/Widget.php';
/** @see Gonium_Widget_Dock */
require_once 'Gonium/Widget/Dock.php';
/** @see Gonium_Layer */
require_once 'Gonium/Widget/Layer.php';

/** Zend_Controller_Plugin_Abstract */
require_once 'Zend/Controller/Plugin/Abstract.php';

/**
 * Control display of widgets over the Layout
 *
 * @package     Bootstrap
 * @subpackage  Init_Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @todo        Load widgets from database and check ACL privileges.
 *              Currently display default widgets only
 */
class Init_Plugin_Widget extends Zend_Controller_Plugin_Abstract {
	
	public $_layer;
	/*
	*
	*/
	public function __construct() {
		$this->_layer = Gonium_Widget_Layer::getInstance ();
	}
	
	/**
	 * Configures the path to the view scripts of Layouts
	 */
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
		parent::dispatchLoopStartup ( $request );
		// If request by ajax, change the layout
		//if( !$this->getRequest()->isXmlHttpRequest() )
		//{
		// Widget Layer
		$layer = Gonium_Widget_Layer::getInstance();
		$layer->setResponse ( $this->getResponse() );
		$layer->enable();
		$layer->enableAutoDocking();
		
		// Widget View
		$view = Zend_Registry::get ( 'core_view' );
		$widget_view = clone $view;
		$widget_view->setScriptPath (array(
		    APP_ROOT . 'Core/view/',
		    //APP_ROOT . 'Core/widgets/views/scripts/',
		    APP_ROOT . 'Core/Widget/views/scripts/',
		    Core::getHomeDir() . 'Widget/views/scripts/',
			'./'
		));
		
		$dock_left = new Gonium_Widget_Dock ( 'header' );
		$dock_left->setView ( $widget_view );
		//$dock_left->setScript('vertical.dock.phtml');
		

		$dock_left = new Gonium_Widget_Dock ( 'leftSidebar' );
		$dock_left->setView ( $widget_view );
		$dock_left->setScript('vertical.dock.phtml');
		

		$dock_right = new Gonium_Widget_Dock ( 'rightSidebar' );
		$dock_right->setView ( $widget_view );
		$dock_right->setScript ( 'vertical.dock.phtml' );
		
		$dock_footer = new Gonium_Widget_Dock ( 'footerSidebar' );
		$dock_footer->setView ( $widget_view );
		$dock_footer->setScript('footer.dock.phtml');

		if ($this->_layer->isEnabled ()) {
			require_once ('Widget/Login.php');
			require_once ('Widget/Validator.php');
			require_once ('Widget/DbInfo.php');
			require_once ('Widget/Gonium.php');
			
			$dock_left = $this->_layer->getDock ( 'leftSidebar' );
			$dock_right = $this->_layer->getDock ( 'rightSidebar' );
			$dock_footer = $this->_layer->getDock ( 'footerSidebar' );
			
			$dock_left->register ( new Widget_Login ( ), 'login' );
			$dock_right->register ( new Widget_Gonium ( ), 'gonium' );
			$dock_right->register( new Widget_Validator(), 'validator');

			$dock_footer->register ( new Widget_dbInfo ( ), 'dbInfo' );
		}
		//}
	}
	
	/**
	 * dispatchLoopShutdown() plugin hook -- render layout
	 *
	 * @param    Zend_Controller_Request_Abstract $request
	 * @return void
	 */
	public function dispatchLoopShutdown() {
		if ($this->_layer->isEnabled ())
			$this->_layer->toResponse ();
	}
}
