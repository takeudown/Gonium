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

require_once 'Zend/Controller/Action.php';

/**
 * @package     Core_Module_Error
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

class Error_Helper_ZendDbAdapterException extends Zend_Controller_Action_Helper_Abstract
	implements Gonium_Controller_Action_Helper_Error_Interface 
{
	public function getTitle()
	{
		try{
			$lang = Zend_Registry::get('Zend_Translate');
			return $lang->translate('Database Error');
		} catch(Exception $e)
		{
			Gonium_Exception::dump($e);
			die();
		}
		
		return 'FAIL';
	}
	
	public function getBody()
	{
		try{
			$lang = Zend_Registry::get('Zend_Translate');
			return $lang->translate('Database Connection Error');
		} catch(Exception $e)
		{
			Gonium_Exception::dump($e);
			die();
		}
		
		return 'FAIL';
	}
}