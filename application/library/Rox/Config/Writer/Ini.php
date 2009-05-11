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
 * @package     Rox_Config
 * @subpackage  Rox_Config_Writer
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Config_Writer_Ini */
require_once 'Zend/Config/Writer/Ini.php';

/**
 * @package     Rox_Config
 * @subpackage  Rox_Config_Writer
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Rox_Config_Writer_Ini extends Zend_Config_Writer_Ini
{
    public function build()
    {
        if ($this->_config === null) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('No config was set');
        }
        
        $this->_iniString   = '';
        $extends     = $this->_config->getExtends();
        $sectionName = $this->_config->getSectionName();
        
        if (is_string($sectionName)) {
            $this->_iniString .= '[' . $sectionName . ']' . "\n"
                       .  $this->_addBranch($this->_config)
                       .  "\n";
        } else {       
            foreach ($this->_config as $sectionName => $data) {
                if (isset($extends[$sectionName])) {
                    $sectionName .= ' : ' . $extends[$sectionName];
                }
                
                $this->_iniString .= '[' . $sectionName . ']' . "\n"
                           .  $this->_addBranch($data)
                           .  "\n";
            }
        }

        return $this->_iniString;
    }
    
    public function write($filename = null, Zend_Config $config = null)
    {
        if ($filename !== null) {
            $this->setFilename($filename);
        }
        
        if ($config !== null) {
            $this->setConfig($config);
        }
        
        if ($this->_filename === null) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('No filename was set');
        }
        
        $result = @file_put_contents($this->_filename, $this->build() );

        if ($result === false) {
            require_once 'Zend/Config/Exception.php';
            throw new Zend_Config_Exception('Could not write to file "' . $this->_filename . '"');
        }
    }
}