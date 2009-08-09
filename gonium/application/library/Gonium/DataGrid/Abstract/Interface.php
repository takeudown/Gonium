<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Abstract_Interface
 *
 * It class to provide a Abstract DataGrid Interface
 *
 * @category    Gonium
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/**
 * @category    Gonium
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
interface Gonium_DataGrid_Abstract_Interface
{
	public function setSelect($select);

	public function getSelect();

	public function getPage();

	public function setPage($page);

	public function setLimit($limit = null);

	public function getLimit();

	public function getNumberRecords();

	public function setDataSource(Gonium_DataGrid_DataSource_Interface $dataSource);

	public function getDataSource();

	public function fetch();

	public function setTotal($total);

	public function getTotal();

	public function isLoaded();

	public function getPager($adapterName = null);

	public function renderPager($adapterName = null);
	
	public function render($adapterName = null);
}