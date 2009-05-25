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
 * @package     Gonium_Db
 * @subpackage  Gonium_Db_Table
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Abstract.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** Zend_Db_Table_Abstract */
require_once 'Zend/Db/Table/Abstract.php';
/** @see Gonium_Model_Interface */
require_once 'Gonium/Model/Interface.php';

/**
 * @package     Gonium_Db
 * @subpackage  Gonium_Db_Table
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Abstract.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
abstract class Gonium_Db_Table_Abstract extends Zend_Db_Table_Abstract
        implements Gonium_Model_Interface
{
    protected static $_prefix;
    public $_originalName;

    public function __construct()
    {
        // Rename table, adding prefix
        $this->rename();
        parent::__construct();
    }

    public static function setPrefix($prefix)
    {
        if(!empty($prefix) && is_scalar($prefix))
        {
            self::$_prefix = (string) $prefix;
        }
    }

    public static function getPrefix()
    {
        return self::$_prefix;
    }

    private function rename()
    {
        $this->_originalName = $this->_name;
        $this->_name = self::$_prefix . $this->_originalName;
    }

    /*
     * Get the amount of Rows of table
     */
    public function getTotal()
    {
        $select = $this->select();
        $select->from( $this->info('name'), array(
                    'count' => 'COUNT('.implode(',', $this->info('primary')).')'
                ));

        return (int) $this->getAdapter()->fetchOne($select->__toString());
    }
}