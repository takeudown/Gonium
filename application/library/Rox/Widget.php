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
 * @version     $Id: Widget.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Rox_Widget_Exception */
require_once 'Rox/Widget/Exception.php';
/** Zend_View */
require_once 'Zend/View.php';

/**
 * @category    Gonium
 * @package     Rox_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Widget.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
abstract class Rox_Widget {

	protected $_output;

	protected $_view;

	protected $_viewScript = 'widget.phtml';

	public function __construct() {
		$this->clean ();
	}

	public function setView(Zend_View $view) {
		$this->_view = $view;
	}

	public function getView() {
		return $this->_view;
	}

	public function execute() {
	}

	public function clean() {
		$this->_output = '';
		$this->setContent('');
	}

    public function setIcon($icon)
    {
        if($this->_view !== null)
        {
            if ($icon)
                $this->_view->assign ( 'icon', $icon );
        }
    }

	public function setTitle($title)
	{
		if($this->_view !== null)
        {
            if ($title)
                $this->_view->assign ( 'title', $title );
        }
	}

	public function setContent($content) {
		if($this->_view !== null)
		{
			if ($content)
				$this->_view->assign ( 'content', $content );
			else
				$this->_view->assign ( 'content', $this->_output );
		}
	}

	final public function render() {
		if ($this->_view === NULL)
			$this->_view = new Zend_View ( );

		try {
			$this->_output = $this->_view->render ( $this->_viewScript ) ;
		} catch ( Rox_Widget_Exception $e ) {
            trigger_error ( $e->getMessage (), E_USER_WARNING );
        }
	}

	final public function __toString() {
		return $this->_output;
	}
}