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
 * @package     Rox_Form
 * @subpackage  Rox_Form_Style
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Rox_Form_Style_Interface */
require_once 'Rox/Form/Style/Interface.php';

/**
 * @package     Rox_Form
 * @subpackage  Rox_Form_Style
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Rox_Form_Style_Table implements Rox_Form_Style_Interface {
	public function setStyle(Zend_Form $form) {
		// Borramos los decoradores por defecto (dl, dt, dd)
		$form->clearDecorators ();
		/**
		 *
		 * Agregamos nuestro descoradores
		 *
		 * FormElements: -
		 * HtmlTag: este decorador creara la tabla dentro del form
		 *          agregamos sus respectivas propiedades
		 *          class: form-table
		 * Form: -
		 */
		$form->setDecorators ( array ('FormElements', array ('HtmlTag', array ('tag' => 'table', 'width' => '100%', 'cellpadding' => 2, 'cellspacing' => 2, 'border' => 1, 'class' => 'form-table' ) ), 'Form' ) );
		
		/**
		 *
		 * Agregamos los decoradores para los elementos
		 *
		 * ViewHelpers: -
		 * HtmlTag: creamos una columna para los elementos (o input/textarea)
		 *          class: form-col
		 * Label: se encargara de crear la columna (td) para el label
		 *        class: form-label
		 * HtmlTag: la fila que contendra los campos y su label
		 *          class: form-row
		 */
		$form->setElementDecorators ( array ('ViewHelper', 'Errors', array (array ('data' => 'HtmlTag' ), array ('tag' => 'td', 'class' => 'form-col' ) ), array ('Label', array ('class' => 'form-label', 'tag' => 'td' ) ), array (array ('row' => 'HtmlTag' ), array ('tag' => 'tr', 'class' => 'form-row' ) ) ) );
		
		// Redecorar grupos
		$form->setDisplayGroupDecorators ( array ('FormElements', array (array ('group' => 'HtmlTag' ), array ('tag' => 'table', 'class' => 'form-group', 'width' => '100%', 'cellpadding' => 2, 'cellspacing' => 2, 'border' => 1 ) ), 'Fieldset', array (array ('data' => 'HtmlTag' ), array ('tag' => 'td', 'class' => 'form-col', 'colspan' => 2 ) ), array (array ('row' => 'HtmlTag' ), array ('tag' => 'tr', 'class' => 'form-row' ) ) ) );
		
		$submit = $form->getElement ( 'submit' );
		if ($submit !== NULL) {
			$submit->removeDecorator ( 'Label' );
			$submit->setOrder ( 100 );
		}
		return $form;
	}
}