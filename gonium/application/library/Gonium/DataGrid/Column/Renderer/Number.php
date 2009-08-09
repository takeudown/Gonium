<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Column_Renderer_Number
 *
 * It class to provide a grid item renderer number
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id$
 */
class Gonium_DataGrid_Column_Renderer_Number extends Gonium_DataGrid_Column_Renderer_Abstract
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
