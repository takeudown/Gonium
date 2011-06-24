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
 * @category    Gonium
 * @package     Bootstrap
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

require_once 'Zend/Application/Bootstrap/Bootstrap.php';

/**
 * Application bootstrap
 * 
 * @uses    Zend_Application_Bootstrap_Bootstrap
 * @package Boostrap
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload ()
    {
        $autoloader = new Zend_Application_Module_Autoloader(
        array('namespace' => 'Default', 'basePath' => dirname(__FILE__)));
        return $autoloader;
    }

    /**
     * Development Logging
     * 
     * @return Zend_Log
     */
    public function _initLogger ()
    {
        $conf = Zend_Registry::get('GoniumCore_Config');
        $log = new Zend_Log();
        Zend_Registry::set('GoniumCore_Log', $log);
        
        if (APP_ENV != 'production')
        {
            // write to Firebug
            $writer = new Zend_Log_Writer_Firebug();
            // log
            $log->addWriter($writer);
        
        } else 
            if ($conf->system->log->file)
            {
                // write to file
                $writer = new Zend_Log_Writer_Stream(
                $conf->system->log->file);
                $log->addWriter($writer);
            }
        
        return $log;
    }

    /**
     * Bootstrap the view doctype
     * 
     * @return void
     */
    protected function _initDoctype ()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        Zend_Registry::set('GoniumCore_View', $view);
    }

    protected function _initModules ()
    {
        $conf = Zend_Registry::get('GoniumCore_Config');
        
        if ($conf->system !== null)
        {
            $this->bootstrap('frontController');
            $front = $this->frontController;
            
            $front->addModuleDirectory(HOME_ROOT . '/Module/');
            $dirConfig = new Zend_Config_Ini(APP_ROOT . '/etc/directories.ini', 
            APP_ENV);
            {
                foreach ($dirConfig as $modules)
                {
                    $front->addModuleDirectory($modules);
                }
            }
        }
    }

    protected function _initAuth ()
    {
        $auth = Zend_Auth::getInstance();
        Zend_Registry::set('GoniumCore_Auth', $auth);
    }

    protected function _initDb ()
    {
        $conf = Zend_Registry::get('GoniumCore_Config');
        
        if ($conf->resources->db !== null)
        {
            $db = $this->getPluginResource('db');
            if ($db instanceof Zend_Application_Resource_Db)
            {
                
                //$db->getDbAdapter()->getProfiler()->setEnabled(
                //	$conf->resources->db->profiler->enabled);
                

                Zend_Db_Table_Abstract::setDefaultAdapter($db->getDbAdapter());
                Gonium_Db_Table_Abstract::setPrefix(
                    $conf->resources->db->prefix);
                
                if (APP_ENV != 'production')
                {
                    $profiler = new Zend_Db_Profiler_Firebug('All DB Queries');
                    $profiler->setEnabled(true);
                    $db->getDbAdapter()->setProfiler($profiler);
                }
                
                Zend_Registry::set('GoniumCore_Db', $db->getDbAdapter());
            }
        }
    }
}