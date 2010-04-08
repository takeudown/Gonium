<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Pager_Abstract
 *
 * It class to provide a Abstract Pager Implementation
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Pager
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/** @see Gonium_DataGrid_Pager_Abstract_Interface */
require_once 'Gonium/DataGrid/Pager/Interface.php';

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Pager
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
abstract class Gonium_DataGrid_Pager_Abstract 
    implements Gonium_DataGrid_Pager_Interface
{
	/**
	 * number of records per page
	 * @access protected
	 * @var integer
	 */
	protected $_limit;

	/**
	 * generated output for records and paging links
	 * @access protected
	 * @var string
	 */
	protected $_output;


	/**
	 * ID attribute for styling paging links
	 * @access protected
	 * @var string
	 */
	protected $_linksId = 'paginglinks';


	/**
	 * Current Page Number
	 * @access protected
	 * @var Int
	 */
	protected $_page;


	/**
	 * Interval or Rank of the Pager (Floor Page)
	 * @access protected
	 * @var Int
	 */
	protected $_onPage;


	/**
	 * Next String
	 * @access protected
	 * @var String
	 */
	protected $_next = 'Next';


	/** 
	 * Previous String
	 * @access protected
	 * @var String
	 */
	protected $_previous = 'Previous';


	/** 
	 * Total number of records
	 * @access protected
	 * @var Int
	 */
	protected $_numberRecords;


	/**
	 * Total total number of pages
	 * @access protected
	 * @var Int
	 */
	protected $_numberPages;


	protected static $_seperator = '<span>&nbsp;&nbsp;</span>';

	/**
	 * Constructor
	 *
	 * @access  public
	 */
	public function __construct($_page, $_pageLimit, $_recordsNum)
	{
		$this->setPage($_page)
		->setlimit($_pageLimit)
		->setNumberRecords($_recordsNum)
		->setNumberPages();
	}

	/**
	 * Set Links Id
	 * @access public
	 * @return void
	 */
	public function setLinksId($linksId)
	{
		$this->_linksId = $linksId;
		return $this;
	}

	/**
	 * Get Links Id
	 *
	 * @access public
	 * @return String
	 */
	public function getLinksId()
	{
		return $this->_linksId;
	}

	/**
	 * Set total number of pages
	 *
	 * @access private
	 * @return int
	 */
	public function setNumberPages()
	{
		// calculate number of pages
		$this->_numberPages = ceil($this->getNumberRecords()/$this->getLimit());
		return $this;
	}

	/**
	 * Get Number of Pages
	 *
	 * @access public
	 * @return int
	 */
	public function getNumberPages()
	{
		return $this->_numberPages;
	}

	/**
	 * Set current page
	 *
	 * @access public
	 * @return int
	 */
	public function setPage($_page)
	{
		$this->_page = $_page;
		return $this;
	}

	/**
	 * Get current page
	 *
	 * @access public
	 * @return int
	 */
	public function getPage()
	{
		return $this->_page;
	}

	/**
	 * Set Number Per Page
	 *
	 * @access public
	 * @return int
	 */
	public function setLimit($_pageLimit)
	{
		$this->_limit = $_pageLimit;
		return $this;
	}

	/**
	 * Get number of records per page
	 *
	 * @access public
	 * @return int
	 */
	public function getLimit()
	{
		return $this->_limit;
	}

	/**
	 * Set total number of records
	 *
	 * @access public
	 * @return int
	 */
	public function setNumberRecords($_recordsNum)
	{
		$this->_numberRecords = $_recordsNum;
		return $this;
	}

	/**
	 * Get total number of records
	 *
	 * @access public
	 * @return int
	 */
	public function getNumberRecords()
	{
		return $this->_numberRecords;
	}

	/**
	 * Calculate and set the floor page
	 *
	 * @access private
	 * @return int
	 */
	public function setOnPage()
	{
		$this->_onPage = floor($this->getPage() / $this->getLimit()) + 1;
		return $this;
	}

	/**
	 * Calculate the floor page
	 *
	 * @access public
	 * @return int
	 */
	public function getOnPage()
	{
		return $this->_onPage;
	}

	/**
	 * Set "next" link text
	 *
	 * @access public
	 * @return void
	 */
	public function setNext($next)
	{
		$this->_next=$next;
		return $this;
	}

	/**
	 * Get the "next" link text
	 *
	 * @access public
	 * @return String
	 */
	public function getNext()
	{
		return $this->_next;
	}

	/**
	 * Set "previous" link text
	 *
	 * @access public
	 * @return void
	 */
	public function setPrevious($previous)
	{
		$this->_previous = $previous;
		return $this;
	}

	/**
	 * Get "previous" link text
	 *
	 * @access public
	 * @return String
	 */
	public function getPrevious()
	{
		return $this->_previous;
	}

	/**
	 * Set the pager output 
	 * @access public
	 * @return Gonium_DataGrid_Pager_Abstract
	 */
	public function setOutput($output)
	{
		$this->_output = $output;
		return $this;
	}

	/**
	 * Get the Pager output
	 *
	 * @access public
	 * @return string Html
	 */
	public function getOutput()
	{
		return $this->_output;
	}

	/**
	 * Display or output the Pager
	 *
	 * @access public
	 * @return string Html
	 */
	public function displayPager()
	{
		return $this->getOutput();
	}

	/**
	 * Filter and return the URL and query string
	 *
	 * @access public
	 * @return string
	 */
	public function getLink($page = null, $emptyQuery = false)
	{
		return Zend_Controller_Action_HelperBroker::getStaticHelper('url')->url(array( 'page' => $page ), null, $emptyQuery);
	}

	/**
	 * Translate
	 */
	public function translate(Zend_Translate $lang)
	{
		$this->setNext( $lang->translate('Next') );
		$this->setPrevious( $lang->translate('Previous') );
	}
	
	/**
	 * Handles building the body of the table
	 *
	 * @access  public
	 * @return  void
	 */
	abstract public function build($addPrevNextText = true);
}
