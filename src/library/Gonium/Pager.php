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
 * @package     Gonium_Pager
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */

//! Gonium Pager
/**
 * Allows easily create a navigation menu pages.
 * It is quite useful for working with search and listings with many records.
 *
 * One tab is a link to the page.
 * The numbers of Records represent the "row" of data, which show each tab.
 *
 * One tab can display 1 or more Records. You can browse through the tabs
 * depending on the Tabs or Records.
 *
 * This class does not create or run SQL queries, only calculates and displays
 * the results links to navigate between pages.
 *
 * @category    Gonium
 * @package     Gonium_Pager
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id$
 */
class Gonium_Pager {

    /**
     * Number of visible pages
     * @var integer
     */
    public $_tabs = 10;

    /**
     * Registers per page
     * @var integer
     */
    public $_limit = 10;

    /**
     * name of GET var for number of registers
     * @var string
     */
    public $_var = 'start';

    /**
     * Default Current Position
     * @var integer
     */
    public $_position = 0;

    /**
     * Left arrow, to first register
     * @var string
     */
    public $_backArrow = ' [&lt;] ';

    /**
     * Right arrow, to last register
     * @var string
     */
    public $_fordwardArrow = ' [&gt;] ';

    /**
     * Left arrow, to first register
     * @var string
     */
    public $_startArrow = ' [&lt;&lt;] ';

    /**
     * Right arrow, to last register
     * @var string
     */
    public $_endArrow = ' [&gt;&gt;] ';

    /**
     * Unlinked text, use {link} to print the numbers
     * @var string
     */
    public $_unlinked = '[{link}]';

    /**
     * Text of links, use {link} to print the numbers
     * @var string
     */
    public $_linked = ' [{link}] ';

    /**
     * Link String
     * @var string
     */
    public $_link = '<a href="?start={start-record}">{tab-name}</a>';

    /**
     * Number of Registers.
     * @var string
     */
    public $_regs = 0;

    public $_startRecordVar = 'start-record';

    public $_tabNameVar = 'tab-name';

    /**
     * Sets the amount of visible tabs. One tab is a link to another page.
     * Throw an Exception if $pages are invalid value.
     *
     * @param integer pages must be greater than to zero
     * @return Gonium_Pager
     */
    public function setTabs($pages) {
        if(is_int($pages) AND $pages > 0)
        {
            $this->_tabs =  $pages;
            return $this;
        }

        throw new Exception('The amount of Tabs must be an integer greater than to zero.');
    }

    /**
     * Sets the amount of records displayed per paged.
     * Throw an Exception if $pages are invalid value.
     *
     * @param integer limit must be greater than to zero
     * @return Gonium_Pager
     */
    public function setEntriesPerPage($limit) {
        if(is_int($limit) AND $limit > 0)
        {
            $this->_limit =  $limit;
            return $this;
        }

        throw new Exception('The amount of Entries per Page must be an integer greater than to zero.');
    }

    /**
     * Sets the text (usually HTML) that will be used to display
     * each tab to a page.
     *
     * {start-record} It can be used for hitting in the text the number
     * of initial record of each page.
     *
     * {tab-name} It can be used for hitting in the text the title
     * of each tab (the number of page)
     *
     * @param string Tab text
     */
    public function setLinkString($link) {
        if(is_string($link) AND !empty($link))
        {
            $this->_link =  $link;

        } else {
            $this->_link = '<a href="?start={start-record}">{tab-name}</a>';
        }
    }

    /**
     * Sets the amount of total records
     * @param integer limit must be greater than to zero
     */
    public function setRegisters($regs) {
        if(is_int($regs) AND $regs >= 0)
        {
            $this->_regs =  $regs;
            return $this;
        }
        else
            return false;
    }

    /**
     * Sets the number of page that is the user, depending on the number
     * of record from which we start to see a page.
     *
     * For example, if records show 10 per page, and setting $pos to 23,
     * the position will be page 3, because of 0 to 10 is the page 1,
     * from 11 to 20 page 2 and 21 to 30 is the page 3
     * (where the registration is given 23).
     *
     * @param integer It must be between zero and the total number of records.
     * @return Gonium_Pager
     */
    public function setPosition($pos) {
        if(is_int($pos) AND $pos >= 0 AND $pos < $this->_regs)
        {
            $this->_position =  $pos;

        } else {
            $this->_position = 0;
            //throw new Exception('The position must be a number between zero and the total number of records.');
        }

        return $this;

    }

    /**
     *     Calculates the number of the tab in which you will find the Record.
     *
     * @param integer It must be between zero and the total number of records.
     * @return Gonium_Pager
     */
    protected function tab($pos = null) {
        if(is_int ($pos))
            return intval($pos / $this->_limit) + 1;
        else
            return intval($this->_position / $this->_limit) + 1;
    }

    /*
     *
     */
    public function countPages()
    {
        return intval( ceil($this->_regs / $this->_limit) );
    }

    public function display() {
        $tabs = $this->countPages();
        $pos = $this->tab();
        // DETECTAR POSICION, INICIAL, MEDIA, FINAL
        $mostrar_inicio=false;
        $mostrar_atras=false;
        $mostrar_adelante=false;
        $mostrar_final=false;

        $browser='{INICIO} {ATRAS} {TABS} {ADELANTE} {FINAL}';
        $str='';

        if($this->_position > 0)
            $mostrar_atras=true;

        if ($pos <= ($this->_tabs / 2) OR $tabs <= $this->_tabs) {
            //INICIAL
            $n = 0;
            if($tabs > $this->_tabs) {
                $mostrar_final=true;
            }
            if(($this->_position + $this->_limit) < $this->_regs)
                $mostrar_adelante=true;
        } elseif($pos >= intval($tabs - ($this->_tabs/2))) {
            // FINAL
            $n = $tabs - $this->_tabs;
            $mostrar_atras=true;
            $mostrar_inicio=true;

            if(($this->_position + $this->_limit) < $this->_regs)
            {
                $mostrar_adelante=true;
                $mostrar_final=true;
            }
        } else {
            // MEDIO
            $n = intval($pos - ($this->_tabs/2));

            $mostrar_atras=true;
            $mostrar_adelante=true;
            $mostrar_inicio=true;
            $mostrar_final=true;
        }


        for ($i = 1;$i <= min($this->_tabs, $tabs);$i++) {
            if(($n + $i) != $pos) {
                $str .=
                str_replace($this->_startRecordVar,(($this->_limit * ($n + $i)) - $this->_limit),
                str_replace('{link}', ($n + $i),
                str_replace($this->_tabNameVar, $this->_linked, $this->_link)));
            } else {
                $str .= str_replace('{link}', ($n + $i), $this->_unlinked);
            }
        }

        if($mostrar_inicio)
        {
            $start = str_replace($this->_tabNameVar, $this->_startArrow, $this->_link);
            $start = str_replace($this->_startRecordVar, '0', $start);
            $browser = str_replace('{INICIO}', $start, $browser);
        } else {
            $browser = str_replace('{INICIO}', '', $browser);
        }

        if($mostrar_final)
        {
            $end = str_replace($this->_tabNameVar, $this->_endArrow, $this->_link);
            $end = str_replace($this->_startRecordVar, ($this->_limit * $tabs - $this->_limit), $end);
            $browser = str_replace('{FINAL}', $end, $browser);
        } else {
            $browser = str_replace('{FINAL}', '', $browser);
        }

        if($mostrar_atras)
        {
            $back = str_replace($this->_tabNameVar, $this->_backArrow, $this->_link);
            $back = str_replace($this->_startRecordVar, max(0, $this->_position - $this->_limit), $back);
            $browser = str_replace('{ATRAS}', $back, $browser);
        } else {
            $browser = str_replace('{ATRAS}', '', $browser);
        }

        if($mostrar_adelante)
        {
            $next = str_replace($this->_tabNameVar, $this->_fordwardArrow, $this->_link);
            $next = str_replace($this->_startRecordVar, ($this->_position) + $this->_limit, $next);
            $browser = str_replace('{ADELANTE}', $next, $browser);
        } else {
            $browser = str_replace('{ADELANTE}', '', $browser);
        }

        return str_replace('{TABS}', $str, $browser);
    }

    public function __toString()
    {
        return $this->display();
    }
}
?>