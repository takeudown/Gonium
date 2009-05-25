<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 *  Copyright (C) 2008 Gonzalo Diaz Cruz
 *
 * LICENSE
 *
 * Gonium is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any
 * later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @category    Gonium
 * @package     Gonium_Validate
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Uri.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/** Zend_Validate_Abstract */
require_once 'Zend/Validate/Abstract.php';
/** Zend_Uri */
require_once 'Zend/Uri.php';

/**
 * @category    Gonium
 * @package     Gonium_Validate
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Uri.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Gonium_Validate_Uri extends Zend_Validate_Abstract
{
    const BAD_URI = 'badUri';

    protected $_messageTemplates = array(
        self::BAD_URI => "Invalid URI",
    );

    public function __construct()
    {
        $this->_messageTemplates = array(
           self::BAD_URI => _('badUri')
        );
    }

    public function isValid($value)
    {
        $this->_setValue($value);

        //Validate the URI
        $valid = Zend_Uri::check($value);
       
        //Return validation result TRUE|FALSE  
        if ($valid)  {
            return true;
        } else {
            $this->_error(self::BAD_URI);
            return false;
        }
    }
}