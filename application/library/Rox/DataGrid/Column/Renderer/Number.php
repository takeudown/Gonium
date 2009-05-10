<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Number
 *
 * It class to provide a grid item renderer number
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Number.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Number.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
class Rox_DataGrid_Column_Renderer_Number extends Rox_DataGrid_Column_Renderer_Abstract
{

    protected function _getValue($row)
    {
        $data = parent::_getValue($row);
        if (!is_null($data)) {
            $value = $data * 1;
        	return $value ? $value: '0'; // fixed for showing zero in grid
        }
        return $this->getColumn()->getDefault();
    }

    public function renderProperty()
    {
        $out = parent::renderProperty();
        if ($this->getColumn()->getGrid()->getFilterVisibility()) {
            $out.= ' width="100px" ';
        }
        return $out;
    }

    public function renderCss()
    {
        return parent::renderCss() . ' a-right';
    }

}
