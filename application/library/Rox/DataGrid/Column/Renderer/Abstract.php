<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Abstract
 *
 * It class to provide a grid item abstract renderer
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/** @see Rox_DataGrid_Column_Renderer_Interface */
include_once 'Rox/DataGrid/Column/Renderer/Interface.php';
 
/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
abstract class Rox_DataGrid_Column_Renderer_Abstract implements Rox_DataGrid_Column_Renderer_Interface
{
	protected $_column;

	public function setColumn($column)
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
	 * @param   Rox_Object $row
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

			$out = '<a href="'.$this->getColumn()->getLink($dir, $this->getColumn()->getIndex()).'" name="'.$this->getColumn()->getId().'" class="' . $className . '"><span class="sort-title">'.$this->getColumn()->getHeader().$icon.'</span></a>';
		}
		else {
			$out = $this->getColumn()->getHeader();
		}
		return $out;
	}

	public function renderProperty()
	{
		$out = ' ';

		if ($width = $this->getColumn()->getWidth()) {
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