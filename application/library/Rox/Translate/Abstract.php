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
 * @package     Rox_Translate
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 */

/** Zend_Translate */
require_once 'Zend/Translate.php';

/** @see Rox_Translate_Exception */
require_once 'Rox/Translate/Exception.php';

/**
 * @category    Gonium
 * @package     Rox_Translate
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 */
class Rox_Translate_Abstract
{
    protected $_lang;

    public function __construct(Zend_Translate $lang)
    {
        if($lang !== null)
            $this->_lang = $lang;
        else
            throw new Rox_Translate_Exception('Null Zend_Translate object');
    }
}
