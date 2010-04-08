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
 * @package     GoniumCore_Model
 * @subpackage  GoniumCore_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/** @see Gonium_Db_Table_Abstract */
require_once 'Gonium/Db/Table/Abstract.php';
/** @see GoniumCore_Model_ACL_Roles */
require_once 'GoniumCore/Model/ACL/Role.php';
/** @see GoniumCore_Model_ACL_Access */
require_once 'GoniumCore/Model/ACL/Access.php';
/** @see GoniumCore_Model_ACL_Resources */
require_once 'GoniumCore/Model/ACL/Resource.php';


/**
 *
 * Database structure:
 *
 * +------------------+       +----------------+       +-------------+      +--------------+
 * |    Resources     |       |    Access      |       |   Roles     |      |  Inheritance |
 * +------------------+       +----------------+       +-------------+      +--------------+
 * | *id              |<--.   | *role_id       |------>| *id         |<-----| *child_id    |
 * | parent_id        |---'`--| *resource_id  N|       +-------------+   `--| *parent_id   |
 * | *privilege      N|<------| *privilege    N|                            | order        |
 * +------------------+       | allow          |                            +--------------+
 *                            +----------------+
 *
 *
 *   *field = PRIMARY KEY( field )
 *   -----> = foreign key constraint
 *
 *   The actual table names should be: Gonium_acl_resources, Gonium_acl_access, acl_roles, Gonium_acl_inheritance.
 *
 * access.allow is a boolean field, that specifies whether the respective rule is an allow rule or a deny rule (important for inherited access).
 *
 */

require_once "Gonium/Model/Abstract.php";

/**
 * @category    Gonium
 * @package     GoniumCore_Model
 * @subpackage  GoniumCore_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class GoniumCore_Model_ACL extends Gonium_Model_Abstract // implements Gonium_Model_Resource_Interface // , Gonium_Model_Roles_Interface, Gonium_Model_Access_Interface
{
	/*
    public static function getResources($resources_id = null)
    {
        $resTable = new ResourcesTable($resources_id);
    }
    */
}


