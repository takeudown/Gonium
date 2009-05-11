<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Abstract
 * 
 * It abstract class to provide Grid and Pager Interface
 * from a data source: Data Base Table, SQL Query, Array
 *
 * @category    Gonium
 * @package     Rox_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/** @see Rox_DataGrid_Interface */
require_once 'Rox/DataGrid/Abstract/Interface.php';

/**
 * @category    Gonium
 * @package     Rox_DataGrid
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
abstract class Rox_DataGrid_Abstract 
    implements Rox_DataGrid_Abstract_Interface, Countable, IteratorAggregate
{
	protected $_total = null;

	/**
	 * Loading state flag
	 *
	 * @var boolean
	 */
	protected $_isCollectionLoaded;

	/**
	 * Data Source Object
	 * @access private
	 * @var Object
	 */
    protected $_datasource = null;

    /**
     * Pager Adapter
     * @author {@link http://labs.gon.cl/gonium Gonzalo Diaz}
     */
	protected $_pagerAdapter = null;
	
	/**
	 * number of records per page
	 * @access protected
	 * @var integer
	 */
	protected $_limit;

	/** Total number of records
	 * @access protected
	 * @var integer
	 */
	protected $_numberRecords = null;

	/** Current Page Number
	 * @access protected
	 * @var integer
	 */
	protected $_page;

	protected $_defaultLimit = 20;

	/**
	 * Array of records.
	 * @var Array
	 * @access private
	 */
	protected $_recordSet = array();

	public function init()
	{}

	public function getSelect()
	{
		return $this->getDataSource()->getSelect();
	}

	public function setSelect($select)
	{
		$this->getDataSource()->setSelect($select);
		return $this;
	}

	public function setPage($page)
	{
		$this->_page = $page;
		return $this;
	}

	public function getPage()
	{
		return $this->_page;
	}

	public function setLimit($limit = null)
	{
		$limit = ($limit !== null)? $limit: $this->_defaultLimit;

		if( !is_int($limit) && ($limit < 0) ) {
			/**
			 * @see Rox_DataGrid_Abstract_Exception
			 */
			require_once 'Rox/DataGrid/Abstract/Exception.php';
			throw new Rox_DataGrid_Abstract_Exception('Invalid number of records ' . $limit);
		}

		$this->_limit = $limit;
		return $this;
	}

	public function getLimit()
	{
		return $this->_limit;
	}

	public function setTotal($total)
	{
		$this->_total = $total;
		return $this;
	}

	public function getTotal()
	{
		return $this->_total;
	}

	/**
	 * Retrieve collection loading status
	 *
	 * @return bool
	 */
	public function isLoaded()
	{
		return $this->_isCollectionLoaded;
	}

	/**
	 * Set collection loading status flag
	 *
	 * @param unknown_type $flag
	 * @return unknown
	 */
	protected function _setIsLoaded($flag = true)
	{
		$this->_isCollectionLoaded = $flag;
		return $this;
	}

	public function setDataSource(Rox_DataGrid_DataSource_Interface $dataSource)
	{
		$this->_datasource = $dataSource;
		return $this;
	}

	public function getDataSource()
	{
		return $this->_datasource;
	}

	/**
	 * Get total number of records
	 *
	 * @access public
	 * @return int
	 */
	public function getNumberRecords() {
		if(null === $this->_numberRecords){
			$this->setNumberRecords();
		}

		return $this->_numberRecords;
	}

	/**
	 * Calculate total number of records
	 *
	 * @access private
	 * @return int
	 */
	protected function setNumberRecords() {
		if(null === $this->_numberRecords){
			if (null !== $this->getDataSource()) {
				$this->_numberRecords = $this->getDataSource()->count();
			} else {
				/**
				 * @see Rox_DataGrid_Abstract_Exception
				 */
				require_once 'Rox/DataGrid/Abstract/Exception.php';
				throw new Rox_DataGrid_Abstract_Exception("Cannot fetch data: no datasource driver loaded.");
			}
		}
	}

	public function fetch()
	{
		try{
			$this->_fetch();
		} catch (Exception $e) {
			/**
			 * @see Rox_DataGrid_Abstract_Exception
			 */
			require_once 'Rox/DataGrid/Abstract/Exception.php';
			throw new Rox_DataGrid_Abstract_Exception("Message Exception: " . $e->getMessage() . "\n");
		}
		return $this;
	}

	public function bindDataSource(Rox_DataGrid_DataSource_Interface $source)
	{
		$this->setDataSource($source);

		try{
			$this->_fetch();
		} catch (Exception $e) {
			/**
			 * @see Rox_DataGrid_Abstract_Exception
			 */
			require_once 'Rox/DataGrid/Abstract/Exception.php';
			throw new Rox_DataGrid_Abstract_Exception("Message Exception: " . $e->getMessage() . "\n");
		}
		return $this;
	}

	public function count()
	{
		return (null === $this->getTotal())? 0: $this->getTotal();
	}

	public function getIterator()
	{
		if($this->getTotal() === null){
			$this->_fetch();
		}

		return new ArrayIterator($this->_recordSet);
	}

	
	/**
     * Get Pager Adapter.
     * If currently is null, a new Pager Adapter is created, using the 
     * gived $pagerAdapter as name. 
     * 
     * @author {@link http://labs.gon.cl/gonium Gonzalo Diaz}
     * @param string $adapterName name or instance of a Pager Adapter
     * @return Rox_DataGrid_Pager_Abstract
     */
	public function getPager($adapterName = null)
	{
		if( $this->_pagerAdapter === null)
		  $this->setPager($adapterName);

		return $this->_pagerAdapter;
	}

    /**
     * Set Pager Adapter
     * 
     * @author {@link http://labs.gon.cl/gonium Gonzalo Diaz}
     * @param Rox_DataGrid_Pager_Abstract|string $pagerAdapter 
     *  name or instance of a Pager Adapter
     * @return Rox_DataGrid_Abstract
     */
    public function setPager($pagerAdapter = null)
    {
        if($pagerAdapter instanceof Rox_DataGrid_Pager_Abstract)
        {
            $this->_pagerAdapter = $pagerAdapter;
        } else {
            $this->_pagerAdapter = Rox_DataGrid_Pager::factory(
              $pagerAdapter, 
              $this->getPage(), 
              $this->getLimit(), 
              $this->getNumberRecords()
            );
        }
        return $this;
    }
    
	public function renderPager($adapterName = null)
	{
		return $this->getPager($adapterName)->build()->displayPager();
	}

	/**
	 * Render block
	 *
	 * @return string
	 */
	public function render($adapterName = null)
	{
		if($this->getTotal() === null){
			$this->_fetch();
		}

		return $this->_render($adapterName);
	}

    /**
     * Serialize as string
     *
     * Proxies to {@link render()}.
     * 
     * @return string
     */
    public function __toString()
    {
        try {
            $return = $this->render();
            return $return;
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_WARNING);
        }
        
        return '';
    }

	abstract protected function _fetch();

	abstract protected function _render($adapterName = null);
}
