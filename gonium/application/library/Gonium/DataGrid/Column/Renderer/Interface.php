<?php
/**
 * Zsamer Framework
 *
 * Gonium_DataGrid_Column_Renderer_Interface
 *
 * It class to provide a grid item renderer interface
 *
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * @package     Gonium_DataGrid
 * @subpackage  Gonium_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Interface.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
interface Gonium_DataGrid_Column_Renderer_Interface
{
    public function setColumn($column);
    
    public function getColumn();

    /**
     * Renders grid column
     *
     * @param Gonium_Object $row
     */
    public function render($row);
}