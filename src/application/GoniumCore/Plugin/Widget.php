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
 * @subpackage  Plugin
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
 * @subpackage  Plugin
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @todo        Load widgets from database and check ACL privileges.
 *              Currently display default widgets only
 */
class GoniumCore_Plugin_Widget extends Zend_Controller_Plugin_Abstract {
	
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
		// Widget View
		$view = Zend_Registry::get ( 'GoniumCore_View' );
		$dockView = clone $view;
		$dockView->setScriptPath (array(
		    APP_ROOT . '/view/',
		    APP_ROOT . '/GoniumCore/Widget/views/scripts/',
		    HOME_ROOT . '/Widget/views/scripts/',
			'./'
		));
		
		// Widget Layer
		$conf = new Zend_Config_Ini(HOME_ROOT.'/etc/widget.ini', APP_ENV);
		$layer = Gonium_Widget_Layer::getInstance();
		$layer->setResponse ( $this->getResponse() );
		$layer->enable(); // <- ??
		$layer->enableAutoDocking();
		
		foreach($conf as $dockName => $dockContent)
		{
			if($dockContent->dockLayout != null && $dockContent->widgets != null)
			{
				$dockObject = new Gonium_Widget_Dock ( $dockName );
				$dockObject->setView ( $dockView );
				$dockObject->setScript($dockContent->dockLayout.'.dock.phtml');
				$dockObject = $this->_layer->getDock ( $dockName );
		
				foreach($dockContent->widgets as $widgetName => $widgetInfo)
				{
					$widgetDir = ucfirst($widgetName);
					$widgetClass = 'Widget_'.$widgetDir;					
					
					$widgetConf = $dockContent->widgets->{$widgetName};
					
					if ($this->_layer->isEnabled () && !is_string($widgetConf) && $widgetConf->class !== null) {
						Zend_Loader::loadClass($widgetClass);
						$widgetObject = new $widgetClass ( $widgetConf );
						
						$widgetView = clone $dockView;
						$widgetView->addScriptPath (array(	
							APP_ROOT . 'GoniumCore/view/',
							APP_ROOT . '/Widget/' . $widgetDir . '/views/scripts/',
							HOME_ROOT . '/Widget/' . $widgetDir . '/views/scripts/',
							'./'
						));
						
						$widgetView->registerHelper( new Gonium_View_Helper_GlobalUrl(), 'GlobalUrl');

						$widgetView->getHelper('GlobalUrl')->setBaseUrl($widgetConf->globalUrl);
						$widgetObject->setView($widgetView);
						
						$dockObject->register($widgetObject, $widgetName, $widgetView);
					}
					
				}
			}
		}
		//}
	}
	
	/**
	 * dispatchLoopShutdown() plugin hook -- render layout
	 *
	 * @param    Zend_Controller_Request_Abstract $request
	 * @return void
	 * @todo	Check multiple calls to this method.
	 */
	public function postDispatch(Zend_Controller_Request_Abstract $request) {
		if ($this->_layer->isEnabled ())
			$this->_layer->toResponse ();
	}
}
