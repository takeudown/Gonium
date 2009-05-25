<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Render_Abstract
 *
 * It class to provide a Abstract Render Implementation
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Render
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Abstract.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Render
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Abstract.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_DataGrid_Render_Abstract
{
	protected $_grid = null;

	public function __construct(Gonium_DataGrid_Interface $grid)
	{
		$this->setGrid($grid);
		$this->init();
	}

	public function init()
	{}

	public function setGrid(Gonium_DataGrid_Interface $grid)
	{
		$this->_grid = $grid;
		return $this;
	}

	public function getGrid()
	{
		return $this->_grid;
	}
}