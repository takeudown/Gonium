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
 * @package     Gonium_Controller
 * @subpackage  Gonium_Controller_Action_Helper
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/**
 * LoadModel Action Helper - Load Model classes
 *
 * @package     Gonium_Controller
 * @subpackage  Gonium_Controller_Action_Helper
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 * @deprecated	Zend_Loader_PluginLoader has the same functionality
 */
class Gonium_Controller_Action_Helper_LoadModel extends Zend_Controller_Action_Helper_Abstract
{
    protected static $loader;
    
    public static function setLoader(Zend_Loader_PluginLoader $loader)
    {
    	self::$loader = $loader;
    }
    
    public static function getLoader()
    {
    	if( is_null(self::$loader) )
    	self::$loader = new Zend_Loader_PluginLoader(array(), 'model');
    	 return self::$loader;
    }
    
    public function getModel($name)
    {
      if(is_null(self::$loader))
        return null;
        
      else
      {
      	$modelName = self::$loader->load($name);
      	return new $modelName();
      }
    }
    
    /**
    * Direct method
    */
    public function direct($name)
    {
    	return $this->getModel($name);
    }
}