<?php
/**
 * Zsamer Framework
 *
 * Rox_DataGrid_Column_Renderer_Text
 *
 * It class to provide a grid item renderer text/string
 *
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Text.php 115 2008-12-03 03:01:49Z gnzsquall $
 */

/**
 * @package     Rox_DataGrid
 * @subpackage  Rox_DataGrid_Column_Renderer
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   Copyright (c) 2008 Bolsa de Ideas. Consultor en TIC {@link http://www.bolsadeideas.cl}
 * @author      Andres Guzman F. <aguzman@bolsadeideas.cl>
 * @version     $Id: Text.php 115 2008-12-03 03:01:49Z gnzsquall $
 */
class Rox_DataGrid_Column_Renderer_Text extends Rox_DataGrid_Column_Renderer_Abstract
{
    /**
     * Format variables pattern
     *
     * @var string
     */
    protected $_variablePattern = '/\\$([a-z0-9_]+)/i';

    /**
     * Renders grid column
     *
     * @param Rox_Object $row
     * @return mixed
     */
    public function _getValue($row)
    {
        $format = $this->getColumn()->getFormat();
        $defaultValue = $this->getColumn()->getDefault();
        if (is_null($format)) {
            // If no format and it column not filtered specified return data as is.
            $data = parent::_getValue($row);
            $string = is_null($data) ? $defaultValue : $data;
            return htmlspecialchars($string);
        }
        elseif (preg_match_all($this->_variablePattern, $format, $matches)) {
        	
            // Parsing of format string
            $formatedString = $format;
            foreach ($matches[0] as $matchIndex=>$match) {
                $value = $row[$matches[1][$matchIndex]];
                $formatedString = str_replace($match, $value, $formatedString);
            }
            return $formatedString;
        } else {
            return htmlspecialchars($format);
        }
    }
}