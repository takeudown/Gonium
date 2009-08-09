<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Pager
 *
 * It class to provide a DataGrid Pager Object
 * for default the Pager is Standard class
 *
 * @category    Gonium
 * @package     Gonium_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/**
 * @category    Gonium
 * @package     Gonium_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
final class Gonium_DataGrid_Pager
{
	const DEFAULT_ADAPTER = 'Standard';

	public static function factory($adapterName = null, $_page, $_pageLimit, $_recordsNum)
	{
		if (null === $adapterName){
			$adapterName = self::DEFAULT_ADAPTER;
		}

		if (!is_string($adapterName) or !strlen($adapterName)) {
			throw new Exception('Adapter name must be specified in a string.');
		}

		$adapterName = 'Gonium_DataGrid_Pager_Adapter_' . $adapterName;

		Zend_Loader::loadClass($adapterName);

		return new $adapterName($_page, $_pageLimit, $_recordsNum);
	}
}
