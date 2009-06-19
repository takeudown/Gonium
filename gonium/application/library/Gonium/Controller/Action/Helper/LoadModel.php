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
 * @version     $Id: LoadModel.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * LoadModel Action Helper - Load Model classes
 *
 * @package     Gonium_Controller
 * @subpackage  Gonium_Controller_Action_Helper
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: LoadModel.php 5 2009-05-11 04:08:28Z gnzsquall $
 * @deprecated	Zend_Loader_PluginLoader has the same functionality
 */
class Gonium_Controller_Action_Helper_LoadModel extends Zend_Controller_Action_Helper_Abstract
{
    const MODEL_PREFIX = 'Model_';

    /**
     * $_paths - paths to Action_Helpers
     *
     * @var array
     */
    static protected $_paths = array(array(
        'dir'    => 'models',
        'prefix' => 'Core_Model_'
    ));

    /**
     * resetPaths() - Restore default dir/prefix
     *
     * @return void
     */
    static public function resetPaths()
    {
        self::$_paths = array(array(
                'dir'    => APP_ROOT . 'core'.DIRECTORY_SEPARATOR.'models',
                'prefix' => 'Core_Model_'
            ));
    }
    /**
     * addPrefix() - Add repository of models by prefix
     *
     * @param string $prefix
     * @return void
     */
    static public function addPrefix($prefix)
    {
        $prefix = rtrim($prefix, CLASS_SEPARATOR);
        $path = str_replace(CLASS_SEPARATOR, DIRECTORY_SEPARATOR, $prefix);
        self::addPath($path, $prefix);
    }

    /**
     * addPath() - Add path to repositories where Models could be found.
     *
     * @param string $path
     * @param string $prefix
     * @return void
     */
    static public function addPath($path, $prefix = '')
    {
        // make sure it ends in a PATH_SEPARATOR
        if (substr($path, -1, 1) != DIRECTORY_SEPARATOR) {
            $path .= DIRECTORY_SEPARATOR;
        }

        // make sure it ends in a CLASS_SEPARATOR
        $prefix = self::_normalizePrefix($prefix);

        $info['dir']    = $path;
        $info['prefix'] = $prefix;

        self::$_paths[] = $info;
        return;
    }

    /**
     * Normalize model name for lookups
     *
     * @param  string $name
     * @return string
     */
    protected static function _normalizeModelName($name, $altPrefix ='')
    {
        if (strpos($name, CLASS_SEPARATOR) !== false) {
            $name = str_replace(' ', '', ucwords(str_replace(CLASS_SEPARATOR, ' ', $name)));
        }

        return ucfirst($altPrefix).ucfirst($name);
    }

    /**
     * Make sure model class prefix ends in a CLASS_SEPARATOR
     *
     * @param  string $name
     * @return string
     */
    protected static function _normalizePrefix($prefix)
    {
        return rtrim($prefix, CLASS_SEPARATOR) . CLASS_SEPARATOR;
    }

    protected static function _normalizeAltPrefix($prefix)
    {
        return rtrim($prefix, CLASS_SEPARATOR) . CLASS_SEPARATOR .
            Gonium_Controller_Action_Helper_LoadModel::MODEL_PREFIX;
    }

    /**
     * getModel() - get helper by name
     *
     * @param  string $name
     * @return Zend_Controller_Action_Helper_Abstract
     */
    public static function getModel($name, $altPrefix ='')
    {
        $registryKey = '_Model/' . self::_normalizeModelName($name, $altPrefix);

        if (!Zend_Registry::isRegistered($registryKey)) {
            Zend_Registry::set($registryKey, self::getNewModel($name, $altPrefix /*, $constructArguments*/));
        }
        return Zend_Registry::get($registryKey);
    }

    public static function getNewModel($name, $altPrefix ='')
    {
        //$model = null;
        $file = $name . '.php';

        $paths = array_reverse(self::$_paths);

        foreach($paths as $info) {
            $dir    = $info['dir'];
            if( !empty($altPrefix) )
                $prefix = self::_normalizeAltPrefix($altPrefix);
            else
                $prefix = $info['prefix'];

            $class = $prefix . $name;

            if (class_exists($class, false)) {
                return new $class();
                break;

            } elseif (Zend_Loader::isReadable($dir . $file)) {
            	var_dump($dir . $file);
            	var_dump( ini_get('include_path') );
            	//die('hstjdsg');
                Zend_Loader::loadFile($dir . $file);

                if (class_exists($class, false)) {
                    return new $class();
                }
            }
        }

        Zend_Loader::loadClass('Gonium_Model_Exception');
        throw new Gonium_Model_Exception(sprintf(
                _('Model class %s not found'),
                $name
            ));
    }

    /**
    * Direct method
    */
    public function direct($name, $altPrefix ='', $altPath='')
    {
        /*
        //self::getActionController();
        if( isset($this) )
        {

            $reflectionObject = new ReflectionObject( $this->getActionController() );
            $module = $reflectionObject->getName();

            //var_dump(self::$_paths);
            //strlen() strpos($module, CLASS_SEPARATOR);

            $pos = strpos($module, CLASS_SEPARATOR);
            $len = strlen($module) - $pos;

            var_dump( substr_replace($module, '', $pos, $len) );

            Gonium_Controller_Action_Helper_LoadModel::addPath(
                APP_ROOT . 'usr' . DS . 'modules' . DS . $module . DS . 'models',
                'Mod_'.ucfirst($module).'_Model_'
            );

            //die();
        } else {
            echo ' Llamado estÃ¡tico a: ' . $name;
        }
        */

        return $this->getModel($name, $altPrefix, $altPath);
    }
}