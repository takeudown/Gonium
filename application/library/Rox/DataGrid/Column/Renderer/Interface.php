<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Interface
 *
 * It class to provide a grid item renderer interface
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
interface Rox_DataGrid_Column_Renderer_Interface
{
    public function setColumn($column);
    
    public function getColumn();

    /**
     * Renders grid column
     *
     * @param Rox_Object $row
     */
    public function render($row);
}