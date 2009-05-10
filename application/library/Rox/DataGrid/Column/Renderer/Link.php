<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Link
 *
 * It class to provide a grid item renderer link
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Link.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Link.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
class Rox_DataGrid_Column_Renderer_Link extends Rox_DataGrid_Column_Renderer_Text
{
	/**
	 * Format variables pattern
	 *
	 * @var string
	 */

	public function render($row)
	{
		$links = $this->getColumn()->getLinks();

		if (empty($links)) {
			return parent::render($row);
		}

		$text = parent::render($row);

		$this->getColumn()->setFormat($links);
		$action = parent::render($row);
		$this->getColumn()->setFormat(null);

		return '<a href="' . $action . '" title="' . $text . '">' . $text . '</a>';
	}
}