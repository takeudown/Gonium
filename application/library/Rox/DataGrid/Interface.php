<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Interface
 *
 * It class to provide a DataGrid Interface
 *
 * @category    Gonium
 * @package     Rox_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/**
 * @category    Gonium
 * @package     Rox_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
interface Rox_DataGrid_Interface
{
	public function setDefaultSort($sortSpec);

	public function getDefaultSort();

	public function setDefaultDir($dir);

	public function getDefaultDir();

	public function getOrder();

	public function getDirection();

	public function addColumn($columnId, $column);

	public function getLastColumnId();

	public function getColumnCount();

	public function getColumn($columnId);
}
