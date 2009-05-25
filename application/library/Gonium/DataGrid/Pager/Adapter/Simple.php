<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Pager_Abstract_Simple
 *
 * It class to provide a Pager Simple Object Implementation
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Pager_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Simple.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** @see Gonium_DataGrid_Pager_Abstract */
require_once 'Gonium/DataGrid/Pager/Abstract.php';

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Pager_Abstract
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Simple.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_DataGrid_Adapter_PagerSimple 
    extends Gonium_DataGrid_Pager_Abstract
{
	/**
	 * Handles building the body of the table
	 *
	 * @todo Make translatable text
	 * @access  public
	 * @return  void
	 */
	public function build(/*$addPrevNextText = true*/)
	{
		if ($this->getNumberPages() == 1 || !$this->getNumberRecords())
		{
			return $this;
		}
		
		$this->setOnPage();

		$next_page = null;
		$previous_page = null;

		if($this->getOnPage() >= $this->getNumberPages())
		{
			$next_page = null;
		} else {
			if ($this->getOnPage() != 1)
			{
				$next_page .= "- ";
			}
			$next_page .= "<a href=\"" . $this->getLink($this->getOnPage() * $this->getLimit()) . "\">" . $this->getNext() . " ($this->getOnPage()/$this->getNumberPages())</a>";
		}

		if($this->getOnPage() <= 1)
		{
			$previous_page = null;
		} else {
			$previous_page = "<a href=\"" . $this->getLink(($this->getOnPage() - 2) * $this->getLimit()) . "\">" . $this->getPrevious() . " ($this->getOnPage()/$this->getNumberPages())</a>";
		}

		$output = '<div id="' . $this->getLinksId() . '">Ir a página:' . ' ' . $next_page . ' | ' . $previous_page .'</div>';

		$this->setOutput($output);
		
		return $this;
	}
}
