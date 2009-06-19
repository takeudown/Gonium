<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Column_Renderer_Link
 *
 * It class to provide a grid item renderer link
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Link.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Link.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_DataGrid_Column_Renderer_Link extends Gonium_DataGrid_Column_Renderer_Text
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