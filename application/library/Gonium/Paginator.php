<?php
/**
 * Zsamer Framework
 *
 * Gonium_Paginator
 *
 * It class to provide Paginator
 * from a data source: Data Base Table, SQL Query, Array
 *
 * @category    Gonium
 * @package     Gonium_Paginator
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Paginator.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** @see Gonium_Paginator_Interface */
require_once 'Gonium/DataGrid/Abstract.php';

/**
 * @category    Gonium
 * @package     Gonium_Paginator
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Paginator.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Paginator extends Gonium_DataGrid_Abstract
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
	 * @param Gonium_DataGrid_DataSource_Interface dataSource
	 * @param int limit
	 * @param array params
	 */
	public function __construct(Gonium_DataGrid_DataSource_Interface $dataSource = null, $limit = null, $page = null)
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
	 * @return Gonium_Paginator 
     */
	protected function _fetch()
	{
		if ($this->isLoaded()) {
			return $this;
		}

		if (null === $this->getDataSource()) {
			/**
			 * @see Gonium_DataGrid_Exception
			 */
			require_once 'Gonium/Paginator/Exception.php';
			throw new Gonium_Paginator_Exception("Cannot fetch data: no datasource driver loaded.");
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