<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Pager_Abstract_Interface
 *
 * It class to provide a Interface Pager Implementation
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Pager_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Pager_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
interface Gonium_DataGrid_Pager_Interface
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
