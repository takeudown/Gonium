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
/** @see Gonium_Model_Resource_Interface */
require_once 'Gonium/Model/ACL/Resource/Interface.php';
/** Zend_Acl_Resource */
require_once 'Zend/Acl/Resource.php';

/**
 * Manage ACL Resources from database.
 * If Iterable mode is enabled, you can iterate results from database.
 * In Iterable mode disabled, results from database must be returned as array.
 *
 * @package     Core_Model
 * @subpackage  Core_Model_ACL
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 * @see setIterable()
 * @see isIterable()
 */
class Core_Model_ACL_Resource extends Gonium_Db_Table_Abstract implements Gonium_Model_ACL_Resource_Interface {
  public $_name = 'core_acl_resource';
  public $_primary = 'resource_id';
  
  protected $_iterable = false;
  protected $_result = null;
  
  ///////////////////////////// ITERATOR METHODS /////////////////////////////
  public function setIterable($bool = true) {
    $this->_iterable = ( boolean ) $bool;
  }
  
  public function isIterable() {
    return $this->_iterable;
  }
  
  public function clearIterator() {
    $this->_result = null;
  }
  ///////////////////////////// ITERATOR METHODS /////////////////////////////
  

  public function rewind() {
    //var_dump($this->_result);
    return ($this->_result !== null ? reset ( $this->_result ) : false);
  }
  
  public function current() {
    //var_dump($this->_result);
    return ($this->_result !== null ? current ( $this->_result ) : false);
  }
  
  public function key() {
    //var_dump($this->_result);
    return key ( $this->_result );
  }
  
  public function next() {
    //var_dump($this->_result);
    return next ( $this->_result );
  }
  
  public function valid() {
    return $this->current () !== false;
  }
  
  ///////////////////////////// COUNTABLE METHODS /////////////////////////////
  /**
   * Count resources from result
   */
  public function count() {
    return count ( $this->_result );
  }
  //////////////////////////// EXTENDED ITERATOR /////////////////////////////
  /**
   * @return Zend_Acl_Resource|null
   */
  public function currentResource() {
    $aux = $this->current ();
    if (is_array ( $aux ) && array_key_exists ( 'resource_name', $aux ) && ! empty ( $aux ['resource_name'] ))
      return new Zend_Acl_Resource ( $aux ['resource_name'] );
    else
      return null;
  }
  /**
   * @return Zend_Acl_Resource|null
   */
  public function currentParent() {
    $aux = $this->current ();
    if (is_array ( $aux ) && array_key_exists ( 'parent_name', $aux ) && ! empty ( $aux ['parent_name'] ))
      return new Zend_Acl_Resource ( $aux ['parent_name'] );
    else
      return null;
  }
  
  /*
    public function currentPrivilege() {
      $aux = $this->current();
        if( is_array($aux) && array_key_exists('privilege', $aux)
          && !empty($aux['privilege']) )
            return new Zend_Acl_Resource( $aux['privilege'] );
        else
            return null;
    }
    */
  ////////////////////////////// MODEL METHODS ///////////////////////////////
  public function addResource($id, $parent_id = null, $privilege = null, $scope = null) {
    $data = array ('resource_id' => $id, 'parent_id' => $parent_id, 'privilege' => $privilege, 'scope' => $scope );
    
    parent::insert ( $data );
  }
  
  /**
   * @todo complete ACL model implementation
   */
  public function changeParent() {
  
  }
  
  /**
   * @todo complete ACL model implementation
   */
  /*
    public function removeResource($id, $privilege = null)
    {

    }
    */
  
  /**
   * Get Resources without check inheritance relations
   * @param Array $resourceNames
   */
  public function getResources(Array $resourceNames = array(), $scope = '') {
    $db = Zend_Registry::get ( 'core_db' );
    $results = array ();
    
    $select = $db->select ()->//->distinct()
      from ( array ('node' => self::getViewPrefix () . 'resource' ), null )->joinCross ( array ('parent' => self::getViewPrefix () . 'resource' ), array ('resource_name', 'parent_name' ) )->group ( array ('parent.resource_name', 'parent.lft' ) )->order ( 'parent.lft' );
    
    // Variable Conditions
    foreach ( $resourceNames as $theResource ) {
      if (is_scalar ( $theResource ))
        $select->orWhere ( 'node.resource_name = ?', $theResource );
    }
    
    $orWhere = $select->getPart ( Zend_Db_Select::WHERE );
    $select->reset ( Zend_Db_Select::WHERE );
    
    $select->where ( 'node.lft >= parent.lft' );
    $select->where ( 'node.lft <= parent.rgt' );
    
    if (! empty ( $orWhere ))
      $select->where ( implode ( ' ', $orWhere ), null, Zend_Db_Select::SQL_WHERE );
    
    $results = $db->fetchAll ( $select );
    
    if ($this->_iterable) {
      $this->_result = $results;
      return $this;
    }
    
    return $results;
  }
  
  /**
   * Get Resources, including the resources of the father who inherit up root
   */
  public function getRelatedResources(Array $resourceIDs = array(), $scope = null) {
    $db = Zend_Registry::get ( 'core_db' );
    $results = array ();
    $resourcesFound = array ();
    //$resourcesSearch = array();
    

    do {
      $select = $db->select ()->distinct ()->from ( $this->_name, array ('resource_id' => 'resource_id', 'parent_id' ) );
      
      $orWhere = '';
      // Componer consulta SQL
      //if($resourceIDs > 0)
      //{
      // Si hay varios recursos, tratarlos como "Or Where"
      foreach ( $resourceIDs as $theResourceID ) {
        if (is_scalar ( $theResourceID ))
          $select->orWhere ( 'resource_id = ?', $theResourceID );
      }
      
      $orWhere = $select->getPart ( Zend_Db_Select::WHERE );
      $select->reset ( Zend_Db_Select::WHERE );
      //}
      

      $resourceIDs = array ();
      
      if (! empty ( $orWhere ))
        $select->OrWhere ( implode ( ' ', $orWhere ), null, Zend_Db_Select::SQL_WHERE );
      
      if (! empty ( $scope ))
        $select->where ( 'scope = ?', $scope );
        
      // Mezclar resultados
      $results = array_merge ( $results, $result = $db->fetchAll ( $select ) );
      
      // Buscar posible padres
      foreach ( $result as $res ) {
        if (! in_array ( $res ['resource_id'], $resourcesFound )) {
          //echo $res['resource_id'];
          $resourcesFound [$res ['resource_id']] = $res ['resource_id'];
        }
        
        if (! in_array ( $res ['parent_id'], $resourcesFound )) {
          $resourceIDs [] = $res ['parent_id'];
        }
      
      }
    } while ( ! empty ( $resourceIDs ) );
    
    return $results;
  }
  
  public function toArray() {
  
  }
}