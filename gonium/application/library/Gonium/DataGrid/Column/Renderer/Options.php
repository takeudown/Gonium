<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Column_Renderer_Options
 *
 * It class to provide a Grid column widget for rendering grid cells that contains mapped values
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
class Gonium_DataGrid_Column_Renderer_Options extends Gonium_DataGrid_Column_Renderer_Text
{
    public function render($row)
    {
        $options = $this->getColumn()->getOptions();
        if (!empty($options) && is_array($options)) {
            $value = $row[$this->getColumn()->getIndex()];
            if (is_array($value)) {
                $res = array();
                foreach ($value as $item) {
                    $res[] = isset($options[$item]) ? $options[$item] : $item;
                }
                return implode(', ', $res);
            }
            elseif (isset($options[$value])) {
                return $options[$value];
            }
        }
        return '';
    }

}
