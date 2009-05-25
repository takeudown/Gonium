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
 * @package     Gonium_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Layer.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * Widget Layer
 * Singleton pattern
 *
 * @category    Gonium
 * @package     Gonium_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Layer.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Widget_Layer
{

   private static $_instance;
   private static $_response;
   private static $_status;
   private static $_autodocking;
   private static $_docks;

   // Constructor privado, para impedir crear nuevos objetos con "new"
   private function __construct() { }

   // Clone prohibido
   public function __clone()
   {
      throw new Exception('Clone unavailable');
   }

   public static function getInstance()
   {
      if (!isset(self::$instance))
      {
         $c = __CLASS__;
         self::$_instance = new $c;
      }

      return self::$_instance;
   }

   public static function setResponse(Zend_Controller_Response_Abstract $response)
   {
      self::$_response = $response;
   }

   /**
   * Enable the automatic transfer of Docks to Response as "named segments"
   */
   public static function enable()
   {
      self::$_status = true;
   }

   /**
   * Disable the automatic transfer of Docks to Response as "named segments"
   */
   public static function disable()
   {
      self::$_status = false;
   }

   public static function isEnabled()
   {
      return self::$_status;
   }

   /**
   * Enable the automatic registration of Dock's in the Layer
   */
   public static function enableAutoDocking()
   {
      self::$_autodocking = true;
   }

   public static function disableAutoDocking()
   {
      self::$_autodocking = false;
   }

   public static function isAutoDocking()
   {
      return self::$_autodocking;
   }

   public function addDock(Gonium_Widget_Dock $dock, $dock_id)
   {
      self::$_docks[$dock_id] = $dock;
   }

   public function dockExists($dock_id)
   {
      if( array_key_exists($dock_id, self::$_docks) )
         return true;
      else
         return false;
   }

   public function getDock($dock_id)
   {
      if( array_key_exists($dock_id, self::$_docks) )
         return self::$_docks[$dock_id];
      else
         throw new Exception('Dock doesn\'t exists');
   }

   public function deleteDock()
   {
   }

   /* Paste all docks to response, using the same name of dock as named segment*/
   public function toResponse()
   {
      if(!empty(self::$_docks))
      {
         foreach(self::$_docks as $segment => $dock)
         {
            self::$_response->insert($segment, $dock->output() );
         }
      }
   }
}