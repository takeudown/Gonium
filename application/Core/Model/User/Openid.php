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
 * @package     Core_Model
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** Zend_Auth */
require_once 'Zend/Auth.php';
/** @see Gonium_Model_Abstract */
require_once 'Gonium/Db/Table/Abstract.php';

/**
 * @category    Gonium
 * @package     Core_Model
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Core_Model_User_Openid
    extends Gonium_Db_Table_Abstract
    implements Gonium_Model_User_Interface

{
    public $_name = 'users_openid';
    public $_primary = 'openid_url';

    /**
     * Get user Id associated to a gived URL
     * If the URL hasn't an associated URL, return null
     *
     * @return string | null
     */
    public static function getID($url)
    {
        $table =new self();
        $db = $table->getAdapter();

        $select = $table->select();
        $select
            ->from($table->_name, 'uid')
            ->where( $db->quoteInto($this->_primary.' = ?', $url ) );

        $result = $table->fetchRow( $select );

        if( is_null($result) )
            return null;
        else
            return $result->uid;
    }
}
