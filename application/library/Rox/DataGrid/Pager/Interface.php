<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Pager_Abstract_Interface
 *
 * It class to provide a Interface Pager Implementation
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Pager_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 114 2008-12-03 02:57:51Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Pager_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 114 2008-12-03 02:57:51Z gnzsquall $
 */
interface Rox_DataGrid_Pager_Interface
{
	public function setPage($_page);
	
	public function getPage();
	
	public function setLimit($_pageLimit);
	
	public function getLimit();
	
	public function setNumberPages();
	
	public function getNumberPages();
	
	public function setNumberRecords($_recordsNum);
	
	public function getNumberRecords();
}
