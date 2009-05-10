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
 * @version     $Id: Widgets.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Rox_Db_Table_Abstract */
require_once 'Rox/Db/Table/Abstract.php';

/**
 * @category    Gonium
 * @package     Core_Model
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Widgets.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Core_Model_Widgets extends Rox_Model_Abstract
{
   protected $_name = 'comments';
   protected $_primary = 'comment_id';

   public static function getWidgets()
   {
      $commentsTable = new CommentsTable();
      return $commentsTable->fetchAll();
   }

   public static function createNewComments($data)
   {
      $commentsTable = new CommentsTable();
      $comment = $commentsTable->createRow($data);
      $comment->save();
   }
}

