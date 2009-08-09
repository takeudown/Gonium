<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Interface
 *
 * It class to provide a DataGrid Interface
 *
 * @category    Gonium
 * @package     Gonium_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/**
 * @category    Gonium
 * @package     Gonium_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
interface Gonium_DataGrid_Interface
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
