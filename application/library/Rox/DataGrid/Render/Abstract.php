<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Render_Abstract
 *
 * It class to provide a Abstract Render Implementation
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Render
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Abstract.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Render
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Abstract.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
class Rox_DataGrid_Render_Abstract
{
	protected $_grid = null;

	public function __construct(Rox_DataGrid_Interface $grid)
	{
		$this->setGrid($grid);
		$this->init();
	}

	public function init()
	{}

	public function setGrid(Rox_DataGrid_Interface $grid)
	{
		$this->_grid = $grid;
		return $this;
	}

	public function getGrid()
	{
		return $this->_grid;
	}
}