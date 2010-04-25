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
 * @package     Gonium_Form
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Form */
require_once 'Zend/Form.php';
/** Zend_Translate */
require_once 'Zend/Translate.php';

/**
 * @package     Gonium_Form
 * @category    Gonium
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_Form extends Zend_Form {

	/**
	 * Add a prefix in "id" attribute of all elements
	 * New prefix will be prepended to current id attribute
	 * 
	 * @param string $newPrefix New prefix 
	 */
	public function setElementPrefixId($newPrefix) {
		foreach ( $this as $element ) {
			$element->setAttrib ( 'id', $newPrefix . $element->getAttrib ( 'id' ) );
		}
	}
	
	/**
	 * Add an "Style" object to the form
	 * @todo Agregar una pila de directorios o prefijos con las clases de estilo
	 */
	public function setStyle($style) {
		if (! ($style instanceof Gonium_Form_Style_Interface)) {
			$style = 'Gonium_Form_Style_' . ucfirst ( $style );
			Zend_Loader::loadClass ( $style );
			$style = new $style ( );
		}
		
		$style->setStyle ( $this );
	}
}