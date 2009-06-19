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
 * @package     Core_Model
 * @subpackage  Core_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Db_Table_Abstract */
require_once 'Gonium/Db/Table/Abstract.php';

/**
 * @package     Core_Model
 * @subpackage  Core_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Core_Model_ACL_Access extends Gonium_Db_Table_Abstract
{
    public $_name = 'core_acl_access';
    public $_primary = array('role_id', 'resource_id', 'privilege');

    /**
    * @param mixed [resources_id, ...]
    * @todo complete ACL model implementation
    */
    /*
    public static function getAccess(Array $resources, Array $roles)
    {
        $select = $this->dbase->select()
            ->from( $this->_name, array( 'role_id','resource_id','privilege','allow' ) );

        // Armar WHERE de recursos
        $whereRes = '';
        foreach($roles AS $role_id)
        {
            $whereRes .= $db->quoteInto('role_id = ?', $role_id);
        }

        if( !empty($whereRes) )
            $select->OrWhere($whereRes);

        // Armar WHERE de roles
        $whereRol = '';
        foreach($roles AS $role_id)
        {
            $whereRol .= $db->quoteInto('role_id = ?', $role_id);
        }

        if( !empty($whereRol) )
            $select->OrWhere($whereRol);

        echo $select->__toString();

        return $db->fetchAll( $select );
    }
    */
}