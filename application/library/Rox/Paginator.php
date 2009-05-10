<?php
/**
 * Zsamer Framework
 *
 * Rox_Paginator
 *
 * It class to provide Paginator
 * from a data source: Data Base Table, SQL Query, Array
 *
 * @category    Gonium
 * @package     Rox_Paginator
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Paginator.php 153 2009-05-10 21:20:21Z gnzsquall $
 */

/** @see Rox_Paginator_Interface */
require_once 'Rox/DataGrid/Abstract.php';

/**
 * @category    Gonium
 * @package     Rox_Paginator
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Paginator.php 153 2009-05-10 21:20:21Z gnzsquall $
 */
class Rox_Paginator extends Rox_DataGrid_Abstract
{
	/**
	 * Mix Object/Array of records.
	 * @var array
	 * @access private
	 */
	protected $_recordSet = null;

	/**
	 * Paginator constructor
	 * @access public
	 * @param Rox_DataGrid_DataSource_Interface dataSource
	 * @param int limit
	 * @param array params
	 */
	public function __construct(Rox_DataGrid_DataSource_Interface $dataSource = null, $limit = null, $page = null)
	{
		$this->setLimit($limit);

		if(null === $page){
			$page = Zend_Controller_Front::getInstance()->getRequest()->getParam('page', 0);
		}

		$this->setPage((int)$page);

		if( null !== $dataSource){
			$this->setDataSource($dataSource);
		}

		$this->init();
	}

	/**
	 * @return Rox_Paginator 
     */
	protected function _fetch()
	{
		if ($this->isLoaded()) {
			return $this;
		}

		if (null === $this->getDataSource()) {
			/**
			 * @see Rox_DataGrid_Exception
			 */
			require_once 'Rox/Paginator/Exception.php';
			throw new Rox_Paginator_Exception("Cannot fetch data: no datasource driver loaded.");
		}

		$this->setNumberRecords();

		$this->_recordSet = $this->getDataSource()->fetch($this->getPage(), $this->getLimit());

		$this->setTotal(count($this->_recordSet));
		$this->_setIsLoaded();
		
		return $this;
	}

	protected function _render($adapterName = null)
	{
		return $this->renderPager($adapterName);
	}
}