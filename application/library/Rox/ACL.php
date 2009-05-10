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
 * @package     Rox_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: ACL.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

 /*
 * This class extends a standard Zend_ACL for use with a database.
 * Written by Michael MistaGee Ziegler
 * License: LGPL v2 or above
 * The constructor expects a Zend_DB object as parameter.
 *
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
 *   The actual table names should be: rox_acl_resources, rox_acl_access, rox_acl_roles, rox_acl_inheritance.
 *
 * access.allow is a boolean field, that specifies whether the respective rule is an allow rule or a deny rule (important for inherited access).
 *
 * The inheritance table stores which Role is to inherit rights from which parent rules. There can
 * be multiple parent rules. If a rule inherits rights from more than one parent, the first rule applicable
 * will be used to determine whether to allow or deny the access rights in question.
 * The order field stores in which order the parents are to be introduced to Zend_ACL, effectively setting
 * the order the parent rights are evaluated in.
 * Using a relational database for this is strongly advised, as it guarantees data integrity.
 *
 * If you intend to give each resource a specific name or collect other data about it, you should create
 * an extra table storing this data and put a foreign key referencing this into the resources table. Same
 * goes for the privileges.
 */

/** Rox_Base */
require_once 'Rox/Base.php';
/** Zend_Db */
require_once 'Zend/Db.php';
/** Zend_Acl */
require_once 'Zend/Acl.php';
/** Zend_Acl_Role */
require_once 'Zend/Acl/Role.php';
/** Zend_Acl_Resource */
require_once 'Zend/Acl/Resource.php';
/** Rox_Model_ACL_Resource_Interface */
require_once 'Rox/Model/ACL/Resource/Interface.php';

/**
 * Access Control List
 *
 * Manage a list of privileges of some Roles to access to some Resources.
 *
 * @category    Gonium
 * @package     Rox_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: ACL.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Rox_ACL extends Zend_ACL
{
    /**#@+
     * Orphan Resource Mode 
     */
    /**! Add orphaned resources as "without parent" */
    const ORPHAN_RESOURCE_ADD = 0;
    /**! Doesn't add orphan resources to ACL */
    const ORPHAN_RESOURCE_IGNORE = 1;
    /**! Throw Exceptions when an orphan resource is detected */
    const ORPHAN_RESOURCE_EXCEPTION = 2;
    /**#@-*/

    /**
     * If all roles are in ACL, return true
     * @return boolean
     */
    public function hasAllRolesOf( array &$searchRoles ){
        foreach( $searchRoles as $theRole )
            if( !$this->hasRole( $theRole ) )
                return false;
        return true;
    }

    /**
     * Add Resources to ACL
     * @return int
     */
    private function addResources(Rox_Model_ACL_Resource_Interface $resources, $nocheckparent = false)
    {
        $lastAddedCount = 0;

        foreach($resources as $theRes)
        {
        	Rox_Base::null($theRes);
            // ACL doesn't has the resource
            if( !$this->has($resources->currentResource()) )
            {
                if( $resources->currentParent() === null  // No tiene padre
                  || $this->has( $resources->currentParent() ) // O el padre existe
                )
                {
                    //var_dump($resources->currentResource());
                    // Agregar el Recurso a la ACL
                    $this->add(
                        $resources->currentResource(),
                        $resources->currentParent()
                    );
                    // Aumentar contador de recursos agregados
                    $lastAddedCount++;
                    // // Quita el recurso del arreglo, para evitar volver  a considerarlo en otra vuelta del while
                    //unset($resources[$resid]);
                } else
                if($nocheckparent)
                {
                    // Agregar el Recurso a la ACL, sin padre
                    $this->add( $resources->currentResource() );
                    $lastAddedCount++;
                }
            }
        }

        return $lastAddedCount;
    }

    /**
     * Load resources from a Resource Model to the ACL
     *
     * You can set the $mode flasg, to change the behavior,
     * in case a resource is found orphaned.
     *
     * - Set $mode to Rox_ACL::ORPHAN_RESOURCE_ADD to add resources as "without parent".
     * - Set $mode to Rox_ACL::ORPHAN_RESOURCE_IGNORE to ignore orphaned resources.
     * - Set $mode to Rox_ACL::ORPHAN_RESOURCE_EXCEPTION to throw Exceptions.
     *
     * Default value of $mode is Rox_ACL::ORPHAN_RESOURCE_EXCEPTION.
     * If $mode has a value different from the described ones, it will
     * treat like the default value.
     * 
     * @param Rox_Model_Resource_Interface $resources
     * @param int $mode
     * @return void
     */
    public function loadResources(Rox_Model_ACL_Resource_Interface $resources, $mode = self::ORPHAN_RESOURCE_EXCEPTION)
    {
        if($resources === NULL || $resources->count() == 0)
            return;

        $totalAddedCount = 0;

        do{
            $continue = false;

            $lastAddedCount = $this->addResources($resources);
            $totalAddedCount = $totalAddedCount + $lastAddedCount;

            // Decidir si continuar o no
            if($totalAddedCount != $resources->count())
                $continue = true;
            else
                $continue = false;

            // Si hubieron huerfanos, decidir que hacer
            if( $resources->count() != 0 && $lastAddedCount == 0)
            {
                switch($mode)
                {
                    case self::ORPHAN_RESOURCE_ADD:
                        // Add Orphan resources as "without parent"
                        $this->addResources($resources, true);
                    case self::ORPHAN_RESOURCE_IGNORE:
                     // Do Nothing
                     $continue = false; // End Cycle
                    break;
                    default:
                     // Throw exception
                     throw new Exception('Orphan resources detected');
                    break;
                }
            }

        } while( $continue );

    }

    public function loadRoles($roles) //(Rox_Model_Roles_Interface $roles)
    {

        // Create an array that stores all roles and their parents
        $dbElements = array();
        foreach( $roles as $theRole )
        {
            if( !isset( $dbElements[ $theRole['id'] ] ) )
                $dbElements[ $theRole['id'] ] = array();
            if( $theRole['parent_id'] !== null )
                $dbElements[ $theRole['id'] ][] = $theRole['parent_id'];
        }

        // Now add to the ACL
        $dbElemCount  = count( $dbElements );
        $aclElemCount = 0;

        // while there are still elements left to be added
        while( $dbElemCount > $aclElemCount ){
            // Check every element in the db
            foreach( $dbElements as $theDbElem => $theDbElemParents ){
                // Check if a parent is invalid to prevent an infinite loop
                // if the relational DBase works, this shouldn't happen
                foreach( $theDbElemParents as $theParent )
                {
                    if( !array_key_exists( $theParent, $dbElements ) ){
                        require_once 'Zend/Acl/Exception.php';
                        throw new Zend_Acl_Exception(
                            "Role id '$theParent' does not exist"
                        );
                    }
                }

                if( !$this->hasRole( $theDbElem ) &&            // if it has not yet been added to the ACL
                    ( empty( $theDbElemParents )  ||            // and no parents exist or
                      $this->hasAllRolesOf( $theDbElemParents ) // we know them all
                    )
                  )
                {
                    // we can add to ACL
                    $this->addRole( new Zend_Acl_Role( $theDbElem ), $theDbElemParents );
                    $aclElemCount++;
                }
            }
        }
    }

    public function loadAccess($access) //(Rox_Model_Access_Interface $rules)
    {
        /// Now create all access rules
        //$access = $this->dbase->fetchAll( $this->dbase->select()->from( 'Rox_acl_access', array( 'role_id','resource_id','privilege','allow' ) ) );

        foreach( $access as $theRule )
        {
            if( $theRule['allow'] == true )
                $this->allow( $theRule['role_id'], $theRule['resource_id'], $theRule['privilege'] );
            else    $this->deny(  $theRule['role_id'], $theRule['resource_id'], $theRule['privilege'] );
        }
    }
}
