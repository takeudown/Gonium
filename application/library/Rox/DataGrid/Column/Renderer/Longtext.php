<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Longtext
 *
 * It class to provide a grid item renderer long text
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Longtext.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Longtext.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
class Rox_DataGrid_Column_Renderer_Longtext extends Rox_DataGrid_Column_Renderer_Abstract
{
    public function render($row)
    {
        $maxLenght = ( $this->getColumn()->getStringLimit() ) ? $this->getColumn()->getStringLimit() : 250;
        $text = parent::_getValue($row);
        $suffix = ( $this->getColumn()->getSuffix() ) ? $this->getColumn()->getSuffix() : '...';

        if( strlen($text) > $maxLenght ) {
            return substr($text, 0, $maxLenght) . $suffix;
        } else {
            return $text;
        }
    }
}