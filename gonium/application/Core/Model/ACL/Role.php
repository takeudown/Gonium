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
class Core_Model_ACL_Role extends Gonium_Db_Table_Abstract
{
    public $_name = 'core_acl_role';
    public $_primary = 'role_id';

    /**
    * Gets all roles that have
    * @param Array $rolesIDSs
    */
    public static function getRoles(Array $roleIDs = array())
    {
        /*
         * SELECT `r`.`id`, `i`.`parent_id`, `i`.* FROM `Gonium_acl_roles` AS `r` LEFT JOIN `Gonium_acl_inheritance` AS `i` ON r.id=i.child_id ORDER BY `child_id` ASC, `order` ASC
         */
        $db = Zend_Registry::get('core_db');
        /// Now create all roles
        $select = $db->select()
            ->from(     array( 'r' => 'Gonium_acl_roles' ), array( 'r.role_id', 'i.parent_role_id' ) )
            ->joinLeft( array( 'i' => 'Gonium_acl_inheritance' ), 'r.role_id=i.parent_role_id' )
            ->order(    array( 'user_id', 'order' ) )
            ;

        if($roleIDs > 0)
        {
            // Si hay varios roles, tratarlos como "Or Where"
            foreach( $roleIDs as $theRoleID)
            {
                if( is_scalar($theRoleID) )
                    $select->orWhere('role_id = ?', $theRoleID);
            }
        }

        //echo $select->__toString();

        return $db->fetchAll( $select );
    }

    /**
    * @param int $userID
    */
    public static function getUserRoles( $userID )
    {
        $db = Zend_Registry::get('core_db');
        /// Now create all roles
        $select = $db->select()
            ->from(     array( 'r' => 'Gonium_acl_roles' ), array( 'r.role_id', 'i.parent_role_id' ) )
            ->joinLeft( array( 'i' => 'Gonium_acl_inheritance' ), 'r.role_id=i.parent_role_id' )
            ->where( 'role_id = ? ', $userID )
            ->order(    array( 'user_id', 'order' ) );

        //$select->__toString();

        return $db->fetchAll( $select );
    }

    /**
     *     Gets the roles that have some access rule for the resources given.
     *  If there are no resources or roles, then gets all.
     *
     * @param mixed
     */
    /*
    public static function getRolesFromAccess(Array $roleIDs = array(), Array $rolesIDs = array())
    {
        $db = Zend_Registry::get('core_db');
        $results = array();
        $rolesFound = array();
        $rolesearch = array();

        do {
            /// Now create all roles
            $select = $db->select()
                ->from(     array( 'r' => 'Gonium_acl_roles' ), array( 'r.role_id', 'i.parent_role_id' ) )
                ->joinLeft( array( 'i' => 'Gonium_acl_inheritance' ), 'r.role_id=i.parent_role_id' )
                ->where( 'role_id = ? ', $userID )
                ->order(    array( 'user_id', 'order' ) );
            $orWhere = '';
            // Componer consulta SQL
            //if($rolesIDs > 0)
            //{
                // Si hay varios recursos, tratarlos como "Or Where"
                foreach( $rolesIDs as $theResourceID)
                {
                    if( is_scalar($theResourceID) )
                        $select->orWhere('resource_id = ?', $theResourceID);
                }

                $orWhere = $select->getPart( Zend_Db_Select::WHERE );
                $select->reset( Zend_Db_Select::WHERE );
            //}

            $rolesIDs = array();

            if( !empty($orWhere) )
                $select->OrWhere( implode(' ', $orWhere), null, Zend_Db_Select::SQL_WHERE);

            if( !empty($scope) )
                $select->where('scope = ?', $scope);

            // Mezclar resultados
            $results = array_merge( $results, $result = $db->fetchAll( $select ) );

            // Buscar posible padres
            foreach($result as $res)
            {
                if( !in_array($res['resource_id'], $rolesFound) )
                {
                    //echo $res['resource_id'];
                    $rolesFound[$res['resource_id']] = $res['resource_id'];
                }

                if( !in_array($res['parent_id'], $rolesFound) )
                {
                    $rolesIDs[] = $res['parent_id'];
                }
            }
        } while( !empty( $rolesIDs ) );
    }
    */
    /**
     *     Gets the roles that have some access rule for the resources given.
     *  If there are no resources or roles, then gets all.
     *
     * @param mixed
     */
    /*
     * public static function getRolesFromAccess()
    {

    }
     */
}