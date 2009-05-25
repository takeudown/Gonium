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
 * @package     User
 * @subpackage  User_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: StoreManager.php 5 2009-05-11 04:08:28Z gnzsquall $
 */


/** @see Gonium_Widget */
require_once 'Gonium/Widget.php';

/**
 * @package     User
 * @subpackage  User_Widget
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: StoreManager.php 5 2009-05-11 04:08:28Z gnzsquall $
 */
class Widget_StoreManager extends Gonium_Widget
{
    public function execute()
    {
    	$output = '<ul>';
    	
        $urlOptions = array(
            'module' => 'storemanager',
            'controller' => 'costumer'
        );

        $output .= '<li><a href="'.$this->_view->url($urlOptions, null, true).'">Clientes</a></li>';

        $urlOptions = array(
            'module' => 'storemanager',
            'controller' => 'product'
        );

        $output .= '<li><a href="'.$this->_view->url($urlOptions, null, true).'">Productos</a></li>';

        $urlOptions = array(
            'module' => 'storemanager',
            'controller' => 'order'
        );

        $output .= '<li><a href="'.$this->_view->url($urlOptions, null, true).'">Pedidos</a><br/></li>';

        $this->setContent($output);
    }
}
