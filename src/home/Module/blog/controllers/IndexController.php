<?php
/**
 * Gonium, Zend Framework based Content Manager System.
 * Copyright (C) 2008 Gonzalo Diaz Cruz
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
 * @version 0.1
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @author Gonzalo Diaz Cruz - http://labs.gon.cl/gonium
 *
 */
class Blog_IndexController extends Zend_Controller_Action
{
    public function init ()
    {
        $this->title = 'Blog';
    }
    public function indexAction ()
    {
        $this->view->headTitle($this->title, 
        Zend_View_Helper_Placeholder_Container_Abstract::PREPEND);
    }
}