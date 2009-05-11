<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Render
 *
 * It class to provide a DataGrid Render Object
 * for default the render is Zend View
 *
 * @category    Gonium
 * @package     Rox_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/**
 * @category    Gonium
 * @package     Rox_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
final class Rox_DataGrid_Render
{
	const DEFAULT_ADAPTER = 'ZendView';

	public static function factory(Rox_DataGrid_Interface $grid, $adapterName = null)
	{
		if (null === $adapterName){
			$adapterName = self::DEFAULT_ADAPTER;
		}

		if (!is_string($adapterName) or !strlen($adapterName)) {
			throw new Exception('Reder Datagrid: Adapter name must be specified in a string.');
		}

		$adapterName = 'Rox_DataGrid_Render_' . $adapterName;

		Zend_Loader::loadClass($adapterName);

		return new $adapterName($grid);
	}
}
