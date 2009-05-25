<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_DataSource_Array
 *
 * It class to provide a DataSource Array Object Implementation
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_DataSource
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Array.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** @see Gonium_DataGrid_DataSource_Interface */
require_once 'Gonium/DataGrid/DataSource/Interface.php';

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_DataSource
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Array.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_DataGrid_DataSource_Array implements Gonium_DataGrid_DataSource_Interface
{
	/**
	 * The array
	 *
	 * @var array
	 * @access private
	 */
	private $_array = array();

	/**
	 * Item count
	 *
	 * @var integer
	 */
	protected $_count = null;

	public function __construct(array $array)
	{
		$this->_array = $array;
		$this->_count = count($array);
	}

	/**
	 * Count
	 *
	 * @access  public
	 * @return  int The number or records
	 */
	public function count()
	{
		return $this->_count;
	}

	/**
	 * Fetch
	 *
	 * @param   integer $offset     Limit offset (starting from 0)
	 * @param   integer $len        Limit length
	 * @access  public
	 * @return  array The 2D Array of the records
	 */
	public function fetch($offset = 0, $len = null, $toArray = false)
	{
		return array_slice($this->_array, $offset, $len);
	}

	/**
	 * Sorts the array.
	 *
	 * @access  public
	 * @param   string  $sortField  Field to sort by
	 * @param   string  $sortDir    Sort direction: 'ASC' or 'DESC'
	 *                              (default: ASC)
	 */
	public function sort($sortField, $sortDir = null)
	{
		$sortAr = array();
		$numRows = $this->_count;

		for ($i = 0; $i < $numRows; $i++) {
			$sortAr[$i] = $this->_array[$i][$sortField];
		}

		$sortDir = (is_null($sortDir) or strtoupper($sortDir) == 'ASC') ? SORT_ASC : SORT_DESC;
		array_multisort($sortAr, $sortDir, $this->_array);
	}

	public function getColumns()
	{
		if(isset($this->_array[0])){
			return array_keys($this->_array[0]);
		}
		return array();
	}
}

