<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Column_Renderer_Abstract
 *
 * It class to provide a grid item abstract renderer
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/** @see Gonium_DataGrid_Column_Renderer_Interface */
include_once 'Gonium/DataGrid/Column/Renderer/Interface.php';
 
/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
abstract class Gonium_DataGrid_Column_Renderer_Abstract implements Gonium_DataGrid_Column_Renderer_Interface
{
	protected $_column;

	public function setColumn(Gonium_DataGrid_Column $column)
	{
		$this->_column = $column;
		return $this;
	}

	public function getColumn()
	{
		return $this->_column;
	}

	/**
	 * Renders grid column
	 *
	 * @param   Gonium_Object $row
	 * @return  string
	 */
	public function render($row)
	{
		return $this->_getValue($row);
	}

	protected function _getValue($row)
	{
		return $row[$this->getColumn()->getIndex()];
	}

	public function renderHeader()
	{
		$params = array();
		
		$out = '';
		if ( (false !== $this->getColumn()->getGrid()->getSortable()) && (false !== $this->getColumn()->getSortable()) ) {
			$className = 'not-sort';
				
			$dir = strtolower($this->getColumn()->getDir());

			$icon = '';
			
			if(!empty($dir)){
				$icon = ($dir == 'asc')? '&dArr;':'&uArr;';
			}

			$dir = ($dir == 'asc') ? 'desc' : 'asc';

			if ($this->getColumn()->getDir()) {
				$className = 'sort-arrow-' . $dir;
			}

			$out = '<a href="'.$this->getColumn()->getLink($dir, $this->getColumn()->getIndex(), $params).'" name="'.$this->getColumn()->getId().'" class="' . $className . '"><span class="sort-title">'.$this->getColumn()->getHeader().$icon.'</span></a>';
		}
		else {
			$out = $this->getColumn()->getHeader();
		}
		return $out;
	}

	public function renderProperty()
	{
		$out = ' ';
		$width = $this->getColumn()->getWidth();

		if ($width) {
			if (!is_numeric($width)) {
				$width = (int)$width;
			}
			$out .='width="'.$width . '" ';
		}
		return $out;
	}

	public function renderCss()
	{
		return $this->getColumn()->getCssClass();
	}

	/**
	 * Escape html entities
	 *
	 * @param   mixed $data
	 * @return  mixed
	 */
	public function htmlEscape($data)
	{
		if (is_array($data)) {
			foreach ($data as $item) {
				return $this->htmlEscape($item);
			}
		}
		return htmlspecialchars($data);
	}
}