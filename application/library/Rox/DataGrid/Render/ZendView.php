<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Render_ZendView
 *
 * It class to provide a Zend View Render Implementation
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Render
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: ZendView.php 118 2008-12-03 08:13:17Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Render
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: ZendView.php 118 2008-12-03 08:13:17Z gnzsquall $
 */
class Rox_DataGrid_Render_ZendView
	extends Rox_DataGrid_Render_Abstract 
	implements Rox_DataGrid_Render_Interface
{
	protected $_template = null;

	public function init()
	{
		$this->setTemplate('grid.phtml');
	}

	public function setTemplate($templateName)
	{
		$this->_template = $templateName;
		return $this;
	}

	public function getTemplate()
	{
		return $this->_template;
	}

	public function render()
	{
		if (!$templateName = $this->getTemplate()) {
			return '';
		}

		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
		$view = clone $viewRenderer->view;
		$view->clearVars();
		$view->grid = $this->getGrid();
		$view->baseUrl = Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl();

		$view->pager = $this->getGrid()->renderPager();

		return $view->render($templateName);
	}
}