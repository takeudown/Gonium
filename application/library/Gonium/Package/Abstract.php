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
 * @package     Gonium_Package
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Abstract.php 5 2009-05-11 04:08:28Z gnzsquall $
 */

/**
 * @category    Gonium
 * @package     Gonium_Package
 * @author      {@link http://blog.gon.cl/cat/zf Gonzalo Diaz Cruz}
 * @license     http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL v2
 * @copyright   2008 {@link http://labs.gon.cl/gonium Gonzalo Diaz Cruz}
 * @version     $Id: Abstract.php 5 2009-05-11 04:08:28Z gnzsquall $
 * @todo        To implement all the logic of installation of Packages
 */
abstract class Gonium_Package_Abstract
{
    final public function __construct()
    {
        /**
         * Comprobar credenciales y controlador para evitar
         * la ejecucion maliciosa del instalador/desinstalador
         */

        /**
         * throw new Exception('Forbidden to use an installer outside administration panel');
         */
    }

    public function getVersion()
    {

    }

    public function getDependencies()
    {

    }

    /**
     * Usado para instalar tablas en la base de datos, crear
     * directorios, archivos, cambiar permisos o cualquier tarea
     * que se deba ejecutar en tiempo de instalacion.
     *
     * Retorna verdadero si todo se ejecuta bien o falso en caso contrario.
     *
     * @return bool false
     */
    public function install()
    {
        return false;
    }

    /**
     * Usado para limpiar la instalacion, borrar tablas de la base de datos,
     * eliminar
     *
     * Retorna verdadero si todo se ejecuta bien o falso en caso contrario.
     *
     * @return bool false
     */
    public function uninstall()
    {
        return false;
    }

}
