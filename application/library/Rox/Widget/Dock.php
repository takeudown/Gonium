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
 * @category    Gonium
 * @package     Rox_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Rox_Widget */
require_once 'Rox/Widget.php';
/** @see Rox_Layer */
require_once 'Rox/Widget/Layer.php';
/** Zend_View */
require_once 'Zend/View.php';

/**
 * @category    Gonium
 * @package     Rox_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Rox_Widget_Dock {
	
	//protected static $_widgetPath;
	protected $_widgetStack;
	//protected $_widgetDecorator;
	//protected $_dockDecorator;
	protected $_script;
	protected $_separator = '';
	protected $_defaultView;
	protected $_output;
	
	public function __construct($dock_id = '', Zend_View $defaultView = null) {
		if (is_null ( $defaultView ))
			$this->_defaultView = new Zend_View ( );
		else
			$this->_defaultView = $defaultView;
		
		$layer = Rox_Widget_Layer::getInstance ();
		
		if ($layer->isEnabled () && $layer->isAutoDocking () && ! empty ( $dock_id )) {
			$layer->addDock ( $this, $dock_id );
		}
		
		$this->_widgetStack = array ();
	}
	
	public function setView(Zend_View $view) {
		$this->_defaultView = $view;
	}
	
	private function widgetName(Rox_Widget $widget) {
		$name = get_class ( $widget );
		return str_replace ( 'Widget_', '', $name );
	}
	
	public function register(Rox_Widget $widget, $instanceName = null, Zend_View $view = null) {
		if (is_null ( $view ))
			$widget->setView ( $this->_defaultView ); // vista predeterminada del Dock
		else
			$widget->setView ( $view ); // vista establecida manualmente
		

		$widget->getView ()->addScriptPath ( array (APP_ROOT . 'Core/view/', APP_ROOT . 'usr/widgets/' . $this->widgetName ( $widget ) . '/views/scripts/', './' ) );
		
		// Clear previous Helper paths
		$widget->getView ()->setHelperPath ( null );
		
		// Reset Rox Libraries View Helpers
		$widget->getView ()->addHelperPath ( 'Rox/View/Helper/', 'Rox_View_Helper' );
		
		// Add View helpers path to module
		$widget->getView ()->addHelperPath ( APP_ROOT . 'usr/modules/' . $this->widgetName ( $widget ) . '/views/helpers', ucfirst ( $this->widgetName ( $widget ) ) . '_View_Helper' );
		
		if (is_null ( $instanceName ) || ! is_scalar ( $instanceName )) {
			$this->_widgetStack [] = $widget;
		} else {
			$this->_widgetStack [$instanceName] = $widget;
		}
	}
	
	public function unregister($name) {
		unset ( $this->_widgetStack [$name] );
	}
	
	public static function addWidgetPath() {
	
	}
	
	public function setScript($script) {
		$this->_script = $script;
	}
	
	public function setSeparator($separator) {
		$this->_separator = $separator;
	}
	
	public function output($flush = true) {
		try {
			$this->_output = array ();
			
			// Ejecutar widgets
			foreach ( $this->_widgetStack as $widget ) {
				$widget->execute ();
				$widget->render ();
				$this->_output [] = ( string ) $widget;
				
				if ($flush)
					$widget->clean ();
			}
			
			if (is_string ( $this->_script ) && $this->_defaultView instanceof Zend_View) {
				
				$this->_defaultView->assign ( 'widgets', implode ( ( string ) $this->_separator, $this->_output ) );
				return $this->_defaultView->render ( $this->_script );
			
			} else {
				return implode ( ( string ) $this->_separator, $this->_output );
			}
		} catch ( Rox_Widget_Exception $e ) {
			trigger_error ( $e->getMessage (), E_USER_WARNING );
		}
		return '';
	}

}