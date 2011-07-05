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
 * @package     Gonium_Form
 * @subpackage  Gonium_Form_Style
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Form_Style_Interface */
require_once 'Gonium/Form/Style/Interface.php';

/**
 * @package     Gonium_Form
 * @subpackage  Gonium_Form_Style
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_Form_Style_Div implements Gonium_Form_Style_Interface
{

    public function setStyle (Zend_Form $form)
    {
        // Form decorators
        $form->setDecorators(
            array('FormElements', 
                array('HtmlTag', array('tag' => '<div>', 'class' => 'form')), 
                'Form'));
        
        // Form Element decorators
        $form->setElementDecorators(
            array('ViewHelper', 
                array('Description', array('tag' => 'div', 'class' => 'help')), 
                'Errors', array('Label'), 
                array('HtmlTag', array('tag' => 'div', 'class' => 'field'))));
        
        foreach ($form as $element)
        {            
            if($element->getType() == 'Zend_Form_Element_Button' || $element->getType() == 'Zend_Form_Element_Submit')
            {
                $element->removeDecorator('Label');
            }
        }
        return $form;
    }
}