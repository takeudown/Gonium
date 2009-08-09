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
 * @package     Gonium_Crypt
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

/**
 * @category    Gonium
 * @package     Gonium_Crypt
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_Crypt_Keygen
{
    protected $_length = 10;
    protected $_useUpperCase = true;
    protected $_useDigits = true;
    protected $_useSigns = false;

    const UNDERCASE_CHARS   = 'abcdefghijklmnopqrstuvwxyz';
    const UPPERCASE_CHARS   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const DIGIT_CHARS       = '1234567890';
    const SIGNS_CHARS       = '|@#~$%()=^*+[]{}-_';

    /**
     *
     */
    public function __construct ($length = 10, $uc = true, $n = true,
        $sc = false)
    {
        $this->setLength($length);
        $this->setUseUpperCase($uc);
        $this->setUseDigits($n);
        $this->setUseSigns($sc);
    }

    public function setLength ($length)
    {
        if($length > 0) {
            $this->_length = $length;
        }

        return $this;
    }

    public function getLength ()
    {
        return $this->_length;
    }

    public function setUseUpperCase ($useUpperCase)
    {
        $this->_useUpperCase = (bool) $useUpperCase;

        return $this;
    }

    public function getUseUpperCase ()
    {
        return $this->_useUpperCase;
    }

    public function setUseDigits ($useDigits)
    {
        $this->_useDigits = (bool) $useDigits;

        return $this;
    }

    public function getUseDigits ()
    {
        return $this->_useDigits;
    }

    public function setUseSigns ($useSigns)
    {
        $this->_useSigns = (bool) $useSigns;

        return $this;
    }

    public function getUseSigns ()
    {
        return $this->_useSigns;
    }

    /**
     * @return string Random Key
     */
    public function __toString ()
    {
        $source = self::UNDERCASE_CHARS;

        if($this->_useUpperCase)
            $source .= self::UPPERCASE_CHARS;
        if($this->_useDigits)
            $source .= self::DIGIT_CHARS;
        if($this->_useSigns)
            $source .= self::SIGNS_CHARS;

        $output = '';
        $source = str_split($source, 1);
        for($i = 1; $i <= $this->_length; $i++) {
            mt_srand((double) microtime() * 1000000);
            $num = mt_rand(1, count($source));
            $output .= $source[$num - 1];
        }

        return $output;
    }
}